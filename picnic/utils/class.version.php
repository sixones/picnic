<?php if (!defined("PICNIC")) { header("Location: /"); exit(1); }

class PicnicVersion {
	public $major = 0;
	public $minor = 0;
	public $release = 0;
	
	public function __construct($major = 0, $minor = 0, $release = 0) {
		$this->major = $major;
		$this->minor = $minor;
		$this->release = $release;
	}
	
	public function __toString() {
		$v = "{$this->major}.{$this->minor}";
		
		if ($this->release != 0) {
			$v .= ".{$this->release}";
		}
		
		return $v;
	}
}

?>