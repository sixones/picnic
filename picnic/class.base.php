<?php if (!defined("PICNIC")) { header("Location: /"); exit(1); }

abstract class PicnicBase {
	protected $_className;
	
	public function __construct() {
		$this->_className = get_class($this);
	}
	
	public function view() {
		return $this->_picnic->view();
	}
}

?>