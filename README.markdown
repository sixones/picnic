Picnic, a lightweight framework engine
======================================

Picnic is a simple framework engine built for speed and extensibility, the engine itself is tiny but it allows you to create full web applications.

Features
--------

* Model view controller structure
* Database support
* Regular expression routing
* PHP templates for speed
* PHP5 Only
* Small footprint

Using
-----

# Download the picnic source
# Create a dispatcher file + include `picnic\class.picnic.php` (see below)
# Code your application

Dispatcher file
---------------

	<?php
	// include picnic
	require_once('picnic/class.picnic.php');

	// create an instance
	$picnic = Picnic::getInstance();
	
	// setup any routes or extra configuration
	$picnic->router()->addRoute(new PicnicRoute("/", "MyControllerClassName", "myActionMethodName"));
	
	// include your applications source files
	require_once("controllers/MyControllerClassName.php");
	
	// call picnics render method
	$picnic->render();
	?>

Examples
--------

See the README in the `examples` directory.