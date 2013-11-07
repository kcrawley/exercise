Read Me
=======

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