<?php

class PicnicController {
	
	private $_picnic;
	private $_result;
	
	public function __construct() {
		$this->_picnic = Picnic::getInstance();
	}
	
	public function call($actionName) {
		$this->_result = $this->$actionName();
		
		return $this->result();
	}
	
	public function picnic() {
		return $this->_picnic;
	}
	
	public function result() {
		return $this->_result;
	}
}

?>