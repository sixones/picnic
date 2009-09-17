<?php

// include picnic
require_once('../../picnic/class.picnic.php');

$picnic = Picnic::getInstance();

$picnic->router()->addRoute(new PicnicRoute("/add/(\d+)/to/(\d+)", "MathsController", "add"));
$picnic->router()->addRoute(new PicnicRoute("/subtract/(\d+)/from/(\d+)", "MathsController", "minus"));

class MathsController extends PicnicController {
	public function add() {
		$result = $this->picnic()->currentRoute()->getSegment(0) + $this->picnic()->currentRoute()->getSegment(1);
		
		$this->picnic()->view()->setTemplate("view.tpl");
		
		return array("result" => $result);
	}
	
	public function minus() {
		$result = $this->picnic()->currentRoute()->getSegment(1) - $this->picnic()->currentRoute()->getSegment(0);
		
		$this->picnic()->view()->setTemplate("view.tpl");
		
		return array("result" => $result);
	}
}

$picnic->render();

?>