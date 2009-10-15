<?php

abstract class PicnicBase {
	protected $_className;
	
	public function __construct() {
		$this->_className = get_class($this);
	}
}

?>