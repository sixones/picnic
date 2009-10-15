<?php

abstract class PicnicController extends PicnicBase {
	
	private $_picnic;
	private $_result;
	private $_params;
	
	private $_action = null;
	
	public function __construct() {
		parent::__construct();
		
		$this->_picnic = Picnic::getInstance();
		
		$this->_params = new PicnicParams();
	}
	
	public function call($actionName) {
		$this->_action = $actionName;
		$controllerName = str_replace("controller", "", strtolower($this->_className));
		
		$this->_result = $this->$actionName();
		
		$action = $this->_action;

		if ($this->picnic()->view()->template() == null) {		
			$this->picnic()->view()->useTemplate("{$controllerName}/{$action}");
		}
		
		return $this->result();
	}
	
	public function redirect($action) {
		$this->_action = $action;
		
		$this->_result = $this->$action();
		
		return $this->result();
	}
	
	public function useTemplate($tpl) {
		$controllerName = str_replace("controller", "", strtolower($this->_className));
	
		$this->picnic()->view()->useTemplate("{$controllerName}/{$tpl}");
	}
	
	public function picnic() {
		return $this->_picnic;
	}
	
	public function params() {
		return $this->_params;
	}
	
	public function result() {
		return $this->_result;
	}
}

?>