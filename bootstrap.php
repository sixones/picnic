<?php

/**
 * You would usually rename the file to `index.php` and route all
 * requests that don't match a file to the bootstrap.
 *
 * <IfModule mod_rewrite.c>
 * 	RewriteEngine On
 * 	RewriteCond %{REQUEST_FILENAME} !-d
 * 	RewriteCond %{REQUEST_FILENAME} !-f
 * 	RewriteRule ^(.*)$ index.php/$1 [QSA,L]
 * </IfModule>
 */

error_reporting(E_ALL);

define("DS", DIRECTORY_SEPARATOR);
define("ROOT_PATH", dirname(__FILE__).DS);

define("PICNIC_HOME", "..".DS."picnic".DS."picnic".DS);
define("APPLICATION_DIR", ROOT_PATH."application/");

require_once(PICNIC_HOME."class.picnic.php");

// application defined bootstrap file
if (file_exists(ROOT_PATH."bootstrap.php")) {
	require_once(ROOT_PATH."bootstrap.php");
}

$picnic = Picnic::getInstance();
$picnic->loadApplication(APPLICATION_DIR);

// render picnic
$picnic->render();

?>