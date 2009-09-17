<?php

class PicnicView {
	private $_picnic;
	private $_smarty;
	
	private $_templatePath;
	
	public function __construct() {
		$this->_picnic = Picnic::getInstance();
	}
	
	public function picnic() {
		return $this->_picnic;
	}
	
	public function setTemplate($path) {
		$this->_templatePath = $path;
	}
	
	public function render($data) {
		if ($this->_templatePath == null || $this->_templatePath == "") {
			throw new PicnicTemplateNotDefinedException();
		}
		
		include($this->_templatePath);
	}
}

?>