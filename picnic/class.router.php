<?php

class PicnicParams {
	protected $_params = array();
	protected $_type = "get";
	
	public function __construct() {
		$this->_type = ($_POST ? "post" : "get");
		
		foreach ($_REQUEST as $key => $val) {
			$this->_params[$key] = $val;
		}
	}
	
	public function params() {
		return $this->_params;
	}
	
	public function type() {
		return $this->_type;
	}
	
	public function get($key, $ifNull = null) {
		if (isset($this->_params[$key])) {
			return $this->_params[$key];
		}
		
		return $ifNull;
	}
}

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
		
		return "/{$url}$/i";
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
	protected $_matchUrl;
	protected $_originalUrl;
	protected $_baseUrl;
	
	protected $_outputType;
	
	public function __construct() {
		$this->_routes = array();
	}
	
	public function outputType($override = null) {
		if ($override != null) {
			$this->_outputType = $override;
		}
		
		if ($this->_outputType == null) {
			return "html";
		}
	
		return $this->_outputType;
	}
	
	public function add($routes) {
		if (is_array($routes)) {
			foreach ($routes as $route) {
				$this->addRoute($route);
			}
		} else {
			$this->_routes[] = $routes;
		}
	}
	
	protected function parseURL($url) {
		$this->_originalUrl = $url;
		$this->_baseUrl = $this->_originalUrl;
		
		if (stripos($this->_baseUrl, "index.php/")) {
			$this->_baseUrl = str_replace("index.php/", "", $this->_baseUrl);
		}
		
		if (stripos($this->_baseUrl, ".")) {
			preg_match("([.]\w+)", $this->_baseUrl, $pieces);
			//$pieces = explode(".", $this->_originalUrl);
			$this->_outputType = ltrim($pieces[(count($pieces) - 1)], ".");
		}
		
		$match = $this->_baseUrl;

		if (strpos($match, "index.{$this->_outputType}") !== false) {
			$match = str_replace("index.{$this->_outputType}", "", $match);
		}
		
		if (strpos($match, ".{$this->_outputType}") !== false) {
			$match = str_replace(".{$this->_outputType}", "", $match);
		}
		
		if (strpos($match, "?") !== false) {
			$match = str_replace("?".$_SERVER["QUERY_STRING"], "", $match);
		}
		
		$this->_matchUrl = str_replace($this->_outputType, "", $match);
		$this->_matchUrl = str_replace("//", "/", $this->_matchUrl);
	}
	
	public function findRouteFor($url) {
		$this->parseURL($url);
		
		//echo "{$this->_originalUrl} -- {$this->_outputType} -- {$this->_matchUrl}";
		
		foreach ($this->_routes as $route) {
			if ($route->matches($this->_matchUrl)) {
				return $route;
			}
		}
	}
}

?>