<?php

class PicnicRoute {
	protected $_matchUrl;
	protected $_controller;
	protected $_action;
	
	protected $_segments;
	
	public function __construct($matchUrl, $controller, $action) {
		$this->_matchUrl = $matchUrl;
		$this->_controller = $controller;
		$this->_action = $action;
	}
	
	public function matchUrl() {
		return $this->_matchUrl;
	}
	
	protected function matchPattern() {
		$url = str_replace("/", "\/", $this->_matchUrl);
		
		return "/{$url}/i";
	}
	
	public function controller() {
		return $this->_controller;
	}
	
	public function action() {
		return $this->_action;
	}
	
	public function segments() {
		return $this->_segments;
	}
	
	public function getSegment($i) {
		return $this->_segments[$i];
	}
	
	public function matches($url) {
		$i = preg_match($this->matchPattern(), $url, $matches);
		
		if ($i > 0) {
			array_shift($matches);
			
			$this->_segments = $matches;
			
			return true;
		}
		
		return false;
	}
}

class PicnicRouter {
	protected $_routes;
	
	public function __construct() {
		$this->_routes = array();
	}
	
	public function addRoute($route) {
		$this->_routes[] = $route;
	}
	
	public function addRoutes($routes) {
		foreach ($routes as $route) {
			$this->addRoute($route);
		}
	}
	
	public function findRouteFor($url) {
		foreach ($this->_routes as $route) {
			if ($route->matches($url)) {
				return $route;
			}
		}
	}
}

?>