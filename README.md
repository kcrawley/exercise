Read Me
=======

Project Requirements

    Create a page with a single form that contains these dropdown boxes, which are all empty initially:
    
    - Client
    - Client Contact
    - Project Type
    
    These 3 fields are used to define a single Campaign. Create a MySQL database to store Campaigns and the values
    selected and submitted for these fields.
    
    This form should be setup to create all the available values which will be used to populate the dropdown boxes,
    and store the values assigned to each Campaign. The user should have the opportunity to create as many Campaigns
    as desired.
    
    There can be multiple Client Contacts and Project Types available for each Client, but only 1 selected value for
    each field. Selecting a new value for Client Name should cause the Client Contact and Project Type fields to be
    refreshed with only the values that are linked to that Client Name.
    
    In order to populate the dropdown boxes, each field should have an “Add New” button beside it that pops up a
    modal window with these fields, as appropriate:
    
    Client
    - Client Name
    - Notes
    
    OR
    
    Client Contact
    - Client Contact Name
    - Notes
    
    OR
    
    Project Type
    - Project Name
    - Notes
    
    Clicking submit on the modal window should run validation to confirm the Name field is unique when compared
    against other entries for that particular field and display an error message, prompting the user to change
    the name if it’s not. If it’s unique, it should be saved to the correct database table based on the original
    field that we’re adding a value for. Saving a Client Contact Name or Project Name should save it as an
    available value only for the Campaign that is currently selected.
    
    After saving the individual contact, the modal should be closed and the value should be added to the original
    dropdown box on the main form and should become the selected value. Repeat the process for all 3 fields using
    JavaScript to update each without refreshing the page.
    
    Submitting the form should save the selected values for all 3 of the fields to a table that stores Campaign
    information.

To install, simply upload this into a Apache web server. AllowOverride and rewrites are required. PHP 5.3+ and a MySQL server.

Configuration is easy... If you upload this onto a websever that is not serving from the root path you will need to make a couple modifications.

##### /app/config/app.php

6: `'basePath'          => ''`

Modify this to include the path of the install, for example, if the application is placed in http://somedomain.com/~test/. You would modify this line as:

6: `'basePath'          => '/~test'`

------

You will have to also modify the Javascript service locator.

##### /_library/main.js

2: `basepath: '',`

Let's assume the same path as above:

2: `basepath: '/~test',`

------

#### Database Configuration

This is pretty simple as well...

##### /app/config/database.php

	return array(
    	'mysql' => array(
        	'host'      => 'localhost',
	        'username'  => 'c3exampledb',
    	    'password'  => '12345',
	        'database'  => 'c3example',
	        'charset'   => 'utf8'
	    )
	);

And that's it. Though if you want to save yourself the hassle, I've put this application on a live host. You may visit [http://example.jonah-mason.com](http://example.jonah-mason.com)
