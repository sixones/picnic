<?php

class PicnicApplication extends PicnicBase {
	private $_routes;
	
	private $_path;
	private $_factory;
	private $_picnic;
	
	private $_configuration;
	
	public function __construct($path) {
		$this->_path = $path;
		
		$this->_factory = new PicnicFactory($this);
		$this->_picnic = Picnic::getInstance();
	}
	
	public function load() {
		$this->_factory->load(array("config", "init"));
		$this->_factory->load(array("config", "routes"), array("r" => $this->_picnic->router()));
		//$this->_factory->load(array("config", "settings"));
	}
	
	public function path() { return $this->_path; }

	public static function loadApplication($path) {
		if (is_dir($path)) {
			$app = new PicnicApplication($path);
			$app->load();
		} else {
			throw new PicnicApplicationNotFound("No application could be found in '{$path}'", 0, "PicnicApplication", "loadApplication");
		}
	}
}

?>