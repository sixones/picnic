<?php

class PicnicFactory {
	private $_instances;
	
	private static $__instance;
	
	private $_application;
	
	public function __construct($app = null) {
		$this->_application = $app;
	}
	
	public function flatten($a) {
		if (is_array($a)) {
			return implode(DS, $a);
		} else {
			return $a;
		}
	}
	
	public function load($file, $args = null) {		
		$path = $this->flatten($file);
		
		if ($this->_application != null) {
			$path = $this->_application->path().$path;
		}
		
		if (stripos(".", $path) === false) {
			$path .= ".php";
		}

		if (!file_exists($path)) {
			throw new PicnicFactoryFileNotFound("Factory could not find '{$path}'", 0, "PicnicFactory", "load");
		}

		if ($args != null) {
			foreach ($args as $key => $val) {
				$$key = $val;
			}
		}
		
		require_once($path);
	}
	
	public static function getInstance() {
		if (self::$__instance == null) {
			self::$__instance = new PicnicFactory();
		}
		
		return self::$__instance;
	}
}

?>