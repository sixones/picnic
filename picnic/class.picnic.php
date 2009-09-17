<?php

if (!defined("PICNIC_DIR")) define("PICNIC_DIR", "");

require_once(PICNIC_DIR . "class.exceptions.php");

require_once(PICNIC_DIR . "class.controller.php");
require_once(PICNIC_DIR . "class.router.php");
require_once(PICNIC_DIR . "class.view.php");

class Picnic {
	
	private $_controller;
	private $_currentRoute;
	private $_database;
	private $_router;
	private $_view;
	
	private static $__instance;
	
	public function __construct() {
		//$this->_database = new PicnicDatabase();
		
		$this->_router = new PicnicRouter();
		
	}
	
	public function controller() {
		return $this->_controller;
	}
	
	public function currentRoute() {
		return $this->_currentRoute;
	}
	
	public function database() {
		return $this->_database;
	}
	
	public function router() {
		return $this->_router;
	}
	
	public function view() {
		return $this->_view;
	}
	
	public function render() {
		$this->_view = new PicnicView();
		
		$this->_currentRoute = $this->router()->findRouteFor($_SERVER["REQUEST_URI"]);
		
		$controllerName = $this->currentRoute()->controller();

		$this->_controller = new $controllerName();
		$this->_controller->call($this->currentRoute()->action());
		
		$this->_view->render($this->controller()->result());
	}
	
	public static function getInstance() {
		if (Picnic::$__instance == null) {
			Picnic::$__instance = new Picnic();
		}
		
		return Picnic::$__instance;
	}
}

?>