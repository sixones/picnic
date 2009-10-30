<?php if (!defined("PICNIC")) { header("Location: /"); exit(1); }

abstract class PicnicController extends PicnicBase {
	private $_picnic;
	private $_result;
	private $_params;
	
	private $_route;
	private $_router;
	private $_view;
	
	private $_action = null;
	
	public function __construct() {
		parent::__construct();
		
		$this->_picnic = Picnic::getInstance();
		
		$this->_params = new PicnicParams();
		
		$this->router($this->_picnic->router());
		$this->view($this->_picnic->view());
	}
	
	public function params() { return $this->_params; }
	public function route($val = null) { if ($val != null) { $this->_route = $val; } return $this->_route; }
	public function router($val = null) { if ($val != null) { $this->_router = $val; } return $this->_router; }
	public function view($val = null) { if ($val != null) { $this->_view = $val; } return $this->_view; }

	public function call($actionName) {
		$this->_action = $actionName;
		$controllerName = str_replace("controller", "", strtolower($this->_className));
		
		$this->_result = $this->$actionName();
		
		$action = $this->_action;

		if ($this->view()->template() == null) {		
			$this->view()->useTemplate("{$controllerName}/{$action}");
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
	
		$this->view()->useTemplate("{$controllerName}/{$tpl}");
	}
	
	public function picnic() {
		return $this->_picnic;
	}
	
	public function result() {
		return $this->_result;
	}
}

?>