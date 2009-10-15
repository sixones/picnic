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

1. Download the picnic source
2. Create a dispatcher file + include `picnic\class.picnic.php` (see below)
3. Code your application

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

License
-------

The MIT License

Copyright (c) 2009 Adam Livesley (sixones)

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.