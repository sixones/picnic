<?php

require_once("../picnic/utils/class.functions.php");
require_once("../picnic/utils/class.xmlparser.php");

$collection = array();

class TVShow {
	public $name;
}

class Episode { 
	public $season;
	public $number;
}

for ($i = 0; $i < 2; $i++) {
	$episode = new Episode();
	$episode->season = 1;
	$episode->number = $i+1;
	
	$collection[] = $episode;
}

$obj1 = new TVShow();
$obj1->name = "Heroes";
$obj1->episodes = $collection;

$obj2 = new TVShow();
$obj2->name = "How I Met Your Mother";
$obj2->episodes = $collection;

$data = array($obj1, $obj2);

/*$data = new StandardObject();
$data->username = "adam";
$data->password = "pass";
$data->collection = array("1", "2", "3", "4", "5"); */

$parser = new PicnicXMLParser();
$parser->loadObjects($data);
$s = $parser->write("")->outputMemory(true);

echo "<h2>from</h2>";

echo "<pre>";
var_dump($data);
echo "</pre>";

echo "<h2>to</h2>";

echo "<textarea style=\"width: 100%; height: 450px;\">";
echo $s;
echo "</textarea>";

echo "<h2>and back to</h2>";

echo "<pre>";
var_dump($parser->read());
echo "</pre>";

echo "<h2>to hello.xml file</h2>";

$parser->writeXMLFile("test.xml");

echo "<h2>and back to php objects</h2>";

$parser->loadXMLFile("test.xml");

echo "<pre>";
var_dump($parser->read());
echo "</pre>";

?>