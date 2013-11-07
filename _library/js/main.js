var campaignManager = {
    basepath: '', // set this to the base path where the backend is installed
    clientId: null,
    contactId: null,
    projectId: null,
    jid: null,
    clientData: {},

    initialize: function () {
        this.getClientData();
        this.events();
    },
    events: function () {
        $(document).on('click', '#learnMore', function() {
            $('#moreinfo').modal();
        });

        $(document).on('click', '#addNewClient', function () {
            campaignManager.loadModal('client', null);
        });

        $(document).on('click', '#addNewContact', function () {
            var id = $(document).find('#editClient').attr('clientid');

            campaignManager.loadModal('contact', id);
        });

        $(document).on('click', '#addNewProject', function () {
            var id = $(document).find('#editClient').attr('clientid');

            campaignManager.loadModal('project', id);
        });

        $(document).on('click', '#editClient', function () {
            campaignManager.clientId = $(this).attr('clientid');

            campaignManager.editModal('client', campaignManager.clientId, null);
        });

        $(document).on('click', '#editContact', function () {
            var jid = $(this).attr('jid');
            campaignManager.clientId = $(document).find('#editClient').attr('clientid');

            campaignManager.editModal('contact', campaignManager.clientId, jid);
        });

        $(document).on('click', '#editProject', function () {
            var jid = $(this).attr('jid');
            campaignManager.clientId = $(document).find('#editClient').attr('clientid');

            campaignManager.editModal('project', campaignManager.clientId, jid);
        });

        $(document).on('click', '#triggerDelete', function () {
            var formData = $("form").serialize();

            $.post(campaignManager.basepath + '/delete', formData, function () {
                $('#modal').modal('hide');
                campaignManager.getClientData();
            });
        });

        /**
         * Checks for keychanges in the name field and warns the user if there is a duplicate detected
         */
        $(document).on('keyup', 'input.client-name', function () {
            var formData = $("form#client-form").serialize();

            $.post(campaignManager.basepath + '/validateClientName', formData, function (data) {
                if (data.status === true) {
                    $("#client-name-group").removeClass('has-error');
                    $("#client-name-group").addClass('has-success');

                    $("#client-modal #triggerSave").removeClass('btn-warning');
                    $("#client-modal #triggerSave").addClass('btn-primary');
                } else {
                    $("#client-name-group").removeClass('has-success');
                    $("#client-name-group").addClass('has-error');

                    $("#client-modal #triggerSave").removeClass('btn-primary');
                    $("#client-modal #triggerSave").addClass('btn-warning');
                }
            });
        });

        /**
         * Saves data that is entered into the modal form
         */
        $(document).on('click', '#modal #triggerSave', function () {
            campaignManager.executeSave();
        });

        /**
         * Loads Data that corresponds to the selected item within the client dropdown
         * **/
        $(document).on('click', '#project-type ul.data-list li a', function (e) {
            e.preventDefault();
            var clientId = $(document).find('#client .client-primary').attr('clientid'),
                internalId = $(this).parent().attr('jid');

            campaignManager.swapProjectButton(clientId, internalId);
            campaignManager.loadProjectInfo(clientId, internalId);
        });

        $(document).on('click', '#client-contact ul.data-list li a', function (e) {
            e.preventDefault();
            var clientId = $(document).find('#client .client-primary').attr('clientid'),
                internalId = $(this).parent().attr('jid');

            campaignManager.swapContactButton(clientId, internalId);
            campaignManager.loadContactInfo(clientId, internalId);
        });

        $(document).on('click', '#client ul.data-list li a', function (e) {
            e.preventDefault();
            var clientId = $(this).parent().attr('id');

            campaignManager.swapClientButton(clientId);
            campaignManager.loadClientInfo(clientId);
            campaignManager.populateContactList(clientId);
            campaignManager.populateProjectList(clientId);

            $('#formatted-contact-list').empty();
            $('#formatted-project-list').empty();
        });
    },
    getClientData: function () {
        this.clientData = {};

        $.getJSON(campaignManager.basepath + '/clients', function (data) {
            $.each(data.package, function (key, val) {
                campaignManager.clientData[val.id] = val;
            });

            campaignManager.resetForm();
        });
    },
    populateClientList: function () {
        var items = [];

        $.each(this.clientData, function (key, val) {
            items.push("<li id=\"" + val.id + "\"><a href=\"#\">" + val.name + "</a></li>");
        });

        $('#client ul.data-list').html(items);
    },
    populateContactList: function (clientId) {
        var listItems = [];

        if (clientId !== undefined) {
            var contacts = this.clientData[clientId].clientContacts;

            if (contacts !== undefined) {
                $.each(this.clientData[clientId].clientContacts, function (key, val) {
                    listItems.push("<li jid=\"" + key + "\" id=\"" + val.id + "\"><a href=\"#\">" + val.contact_name + "</a></li>");
                });
            } else {
                listItems.push("<li><a>No records found.</a></li>")
            }

            this.setAddNew('contact');
        } else {
            listItems.push("<li><a>Please choose a client.</a></li>");
        }

        $('#client-contact ul.data-list').html(listItems);
    },
    populateProjectList: function (clientId) {
        var listItems = [];

        if (clientId !== undefined) {
            var projects = this.clientData[clientId].campaignProjectTypes;

            if (projects !== undefined) {
                $.each(this.clientData[clientId].campaignProjectTypes, function (key, val) {
                    listItems.push("<li jid=\"" + key + "\" id=\"" + val.id + "\"><a href=\"#\">" + val.project_name + "</a></li>")
                });
            } else {
                listItems.push("<li><a>No records found.</a></li>");
            }

            this.setAddNew('project');
        } else {
            listItems.push("<li><a>Please choose a client.</a></li>");
        }

        $('#project-type ul.data-list').html(listItems);
    },
    loadClientInfo: function (clientId) {
        var clientName = campaignManager.clientData[clientId].name,
            notes = campaignManager.clientData[clientId].notes,
            listItems = [];

        listItems.push('<dt>' + clientName + '</dt>');
        listItems.push('<dd>' + notes + '</dd>');

        $('#formatted-client-list').html(listItems);
    },
    loadContactInfo: function(clientId, internalId) {
        var contactName = campaignManager.clientData[clientId].clientContacts[internalId].contact_name,
            notes = campaignManager.clientData[clientId].clientContacts[internalId].notes,
            listItems = [];

        listItems.push('<dt>' + contactName + '</dt>');
        listItems.push('<dd>' + notes + '</dd>');

        $('#formatted-contact-list').html(listItems);
    },
    loadProjectInfo: function(clientId, internalId) {
        var projectName = campaignManager.clientData[clientId].campaignProjectTypes[internalId].project_name,
            notes = campaignManager.clientData[clientId].campaignProjectTypes[internalId].notes,
            listItems = [];

        listItems.push('<dt>' + projectName + '</dt>');
        listItems.push('<dd>' + notes + '</dd>');

        $('#formatted-project-list').html(listItems);
    },
    swapClientButton: function (clientId) {
        if (clientId !== undefined) {
            $('.client-primary').attr('id', 'editClient').html(campaignManager.clientData[clientId].name).attr('clientid', clientId);
        }

        if ($(document).find('#client ul.data-list #addNewClient').length === 0) {
            $('#client ul.data-list').prepend("<li><a id=\"addNewClient\" style=\"cursor: pointer; \">Add New Record</a></li>");
        }
    },
    swapContactButton: function (clientId, internalId) {
        if (clientId !== undefined && internalId !== undefined) {
            $('.contact-primary').attr('id', 'editContact').html(campaignManager.clientData[clientId].clientContacts[internalId].contact_name).
                attr('contactid', campaignManager.clientData[clientId].clientContacts[internalId].id).attr('jid', internalId);
        }

        if ($(document).find('#client-contact ul.data-list #addNewContact').length === 0) {
            $('#client-contact ul.data-list').prepend("<li><a id=\"addNewContact\" style=\"cursor: pointer; \">Add New Record</a></li>");
        }
    },
    swapProjectButton: function (clientId, internalId) {
        if (clientId !== undefined && internalId !== undefined) {
            $('.project-primary').attr('id', 'editProject').html(campaignManager.clientData[clientId].campaignProjectTypes[internalId].project_name).
                attr('projectid', campaignManager.clientData[clientId].campaignProjectTypes[internalId].id).attr('jid', internalId);
        }

        if ($(document).find('#project-type ul.data-list #addNewProject').length === 0) {
            $('#project-type ul.data-list').prepend("<li><a id=\"addNewProject\" style=\"cursor: pointer; \">Add New Record</a></li>");
        }
    },
    loadModal: function (type, id) {
        $.getJSON(campaignManager.basepath + '/modal', 'modalType=' + type, function (data) {
            $('#modal').html(data.html);
            $(document).find('input[name="campaign_client_id"]').val(id);
        });
        $('#modal').modal();
    },
    executeSave: function () {
        var formData = $("form").serialize(),
            method = $("input[name='method']").val(),
            route = campaignManager.basepath + '/' + method;

        if (method !== 'add' && this.clientId !== null) {
            route += '/' + this.clientId;
        }

        $.post(route, formData, function (data) {
            if (data.status === true) {
                $('#modal').modal('hide');
                campaignManager.getClientData();
            } else {
                $('#modal').html(data.html);
            }
        });
    },
    editModal: function (type, id, jid) {
        $.getJSON(campaignManager.basepath + '/modal', 'modalType=' + type, function (data) {
            $('#modal').html(data.html);
            campaignManager.clientId = id;

            switch(type) {
                case 'client':
                    var clientName = campaignManager.clientData[id].name,
                        notes = campaignManager.clientData[id].notes,
                        recordId = campaignManager.clientData[id].id

                    $(document).find('input[name="name"]').val(clientName);
                    break;
                case 'contact':
                    var contactName = campaignManager.clientData[id].clientContacts[jid].contact_name,
                        notes = campaignManager.clientData[id].clientContacts[jid].notes,
                        recordId = campaignManager.clientData[id].clientContacts[jid].id;

                    $(document).find('input[name="contact_name"]').val(contactName);
                    break;
                case 'project':
                    var projectName = campaignManager.clientData[id].campaignProjectTypes[jid].project_name,
                        notes = campaignManager.clientData[id].campaignProjectTypes[jid].notes,
                        recordId = campaignManager.clientData[id].campaignProjectTypes[jid].id;

                    $(document).find('input[name="project_name"]').val(projectName);
                    break;
            }

            $(document).find('input[name="campaign_client_id"]').val(id);
            $(document).find('textarea[name="notes"]').val(notes);
            $(document).find('input[name="method"]').val('update');
            $(document).find('input[name="record_id"]').val(recordId);
            $('.dialog-footer').append('<button id="triggerDelete" type="button" class="btn btn-danger">Delete Record</button>');
        });
        $('#modal').modal();
    },
    resetForm: function() {
        this.populateClientList();
        this.populateContactList();
        this.populateProjectList();
        this.setAddNew('client');
        this.setAddNew('contact-empty');
        this.setAddNew('project-empty');
        $('#formatted-client-list').empty();
        $('#formatted-contact-list').empty();
        $('#formatted-project-list').empty();
    },
    setAddNew: function(type) {
        switch (type) {
            case 'client':
                $('.client-primary').attr('id', 'addNewClient').html('Add New Client');
                break;
            case 'contact':
                $('.contact-primary').attr('id', 'addNewContact').html('Add New Contact');
                break;
            case 'project':
                $('.project-primary').attr('id', 'addNewProject').html('Add New Record');
                break;
            case 'contact-empty':
                $('.contact-primary').attr('id', '').html('Please choose a client...');
                break;
            case 'project-empty':
                $('.project-primary').attr('id', '').html('Please choose a client...');
                break;
        }
    }
};