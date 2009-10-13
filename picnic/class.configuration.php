<?php

class PicnicConfiguration {
	protected $_configuration;
	
	public function __construct($path) {
		include($path);
		
		$this->_configuration = $c;
	}
	
	public function get($key) {
		return $this->_configuration[$key];
	}
}

?>