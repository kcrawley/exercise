<?php namespace Controllers;

use Core\Input;
use Core\Response;
use Core\Session;
use Core\View;
use Models\CampaignClientContacts;
use Models\CampaignClients;
use Models\CampaignProjectTypes;

class ModalController {
    protected $viewData;

    public function deliverModal()
    {
        $view = $this->generateModal($_GET['modalType']);

        return Response::json(array('html' => $view));
    }

    public function generateModal($type = null, array $data = array())
    {
        $viewData = array();
        $type = isset($type) ? $type : $_GET['modalType'];

        switch($type) {
            case 'client':
                $viewData['modalTitle'] = 'Client Manager';
                $viewData['modalClass'] = 'client-name';
                $viewData['formName']   = 'name';
                $viewData['formLabel']  = 'Name';
                $viewData['formType']   = 'client';
                break;
            case 'contact':
                $viewData['modalTitle'] = 'Contact Manager';
                $viewData['modalClass'] = 'contact-name';
                $viewData['formName']   = 'contact_name';
                $viewData['formLabel']  = 'Contact Name';
                $viewData['formType']   = 'contact';
                break;
            case 'project':
                $viewData['modalTitle'] = 'Project Manager';
                $viewData['modalClass'] = 'project-name';
                $viewData['formName']   = 'project_name';
                $viewData['formLabel']  = 'Project Name';
                $viewData['formType']   = 'project';
                break;
        }

        $viewData = array_merge($data, $viewData);

        return View::make('modal', $viewData);

    }

    public function validateClientName()
    {
        $response = CampaignClients::validateName($_POST['name']);

        return Response::json(array('status' => ($response[0]->count !== '1')));
    }

    public function add()
    {
        switch($_POST['form-type']) {
            case 'client':
                return $this->addClient();
                break;
            case 'contact':
                return $this->addContact();
                break;
            case 'project':
                return $this->addProject();
                break;
        }
    }

    public function update($id)
    {
        switch($_POST['form-type']) {
            case 'client':
                return $this->updateClient($id);
                break;
            case 'contact':
                return $this->updateContact($id);
                break;
            case 'project':
                return $this->updateProject($id);
                break;
        }
    }

    public function delete()
    {
        switch($_POST['form-type']) {
            case 'client':
                return $this->deleteClient(Input::get('record_id'));
                break;
            case 'contact':
                return $this->deleteContact(Input::get('record_id'));;
                break;
            case 'project':
                return $this->deleteProject(Input::get('record_id'));;
                break;
        }
    }

    protected function deleteClient($id)
    {
        CampaignClients::delete($id);

        return Response::json(array('status' => true));
    }

    protected function updateClient($id)
    {
        if ($this->validateClient($id) === true) {
            $this->viewData['name'] = Input::get('name');
            $this->viewData['notes'] = Input::get('notes');

            return Response::json(array('status' => false, 'html' => $this->generateModal('client', $this->viewData)));
        } else {
            CampaignClients::update($id);
            return Response::json(array('status' => true));
        }
    }

    protected function addClient()
    {
        if ($this->validateClient() === true) {
            $this->viewData['name'] = Input::get('name');
            $this->viewData['notes'] = Input::get('notes');

            $modal = new ModalController();

            return Response::json(array('status' => false, 'html' => $modal->generateModal('client', $this->viewData)));
        } else {
            CampaignClients::create();
            return Response::json(array('status' => true));
        }
    }

    protected function validateClient($id = 0)
    {
        $errors = false;
        $nameValidation = CampaignClients::validateName(Input::get('name'), $id);
        $nameIsEmpty = (Input::get('name') === '');

        if ($nameValidation[0]->count === '1') {
            $errors = true;
            $this->viewData['formError'] = 'That name already exists, please try again.';
        } else if ($nameIsEmpty) {
            $errors = true;
            $this->viewData['formError'] = 'The name field may not be left empty.';
        }

        return $errors;
    }

    protected function deleteContact($id)
    {
        CampaignClientContacts::delete($id);
        return Response::json(array('status' => true));
    }

    protected function updateContact($id)
    {
        $errors = false;
        $nameIsEmpty = (Input::get('contact_name') === '');

        if ($nameIsEmpty) {
            $errors = true;
            $this->viewData['formError'] = 'The contact name field may not be left empty.';
        }

        if ($errors) {
            $this->viewData['contact_name'] = Input::get('contact_name');
            $this->viewData['notes'] = Input::get('notes');

            $modal = new ModalController();

            return Response::json(array('status' => false, 'html' => $modal->generateModal('contact', $this->viewData)));
        } else {
            CampaignClientContacts::update($id);
            return Response::json(array('status' => true));
        }
    }

    protected function addContact()
    {
        $errors = false;
        $nameIsEmpty = (Input::get('contact_name') === '');

        if ($nameIsEmpty) {
            $errors = true;
            $this->viewData['formError'] = 'The contact name field may not be left empty.';
        }

        if ($errors) {
            $this->viewData['contact_name'] = Input::get('contact_name');
            $this->viewData['notes'] = Input::get('notes');

            $modal = new ModalController();

            return Response::json(array('status' => false, 'html' => $modal->generateModal('contact', $this->viewData)));
        } else {
            CampaignClientContacts::create();
            return Response::json(array('status' => true));
        }
    }

    protected function deleteProject($id)
    {
        CampaignProjectTypes::delete($id);
        return Response::json(array('status' => true));
    }

    protected function addProject()
    {
        $errors = false;
        $nameIsEmpty = (Input::get('project_name') === '');

        if ($nameIsEmpty) {
            $errors = true;
            $this->viewData['formError'] = 'The project name field may not be left empty.';
        }

        if ($errors) {
            $this->viewData['project_name'] = Input::get('project_name');
            $this->viewData['notes'] = Input::get('notes');

            $modal = new ModalController();

            return Response::json(array('status' => false, 'html' => $modal->generateModal('project', $this->viewData)));
        } else {
            CampaignProjectTypes::create();
            return Response::json(array('status' => true));
        }
    }

    protected function updateProject($id)
    {
        $errors = false;
        $nameIsEmpty = (Input::get('project_name') === '');

        if ($nameIsEmpty) {
            $errors = true;
            $this->viewData['formError'] = 'The project name field may not be left empty.';
        }

        if ($errors) {
            $this->viewData['project_name'] = Input::get('project_name');
            $this->viewData['notes'] = Input::get('notes');

            $modal = new ModalController();

            return Response::json(array('status' => false, 'html' => $modal->generateModal('project', $this->viewData)));
        } else {
            CampaignProjectTypes::update($id);
            return Response::json(array('status' => true));
        }
    }
} 