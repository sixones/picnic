<?php

class ArrayCollection {
	protected $_collection;
	
	public function __construct($collection = null) {
		$result = null;
		
		if ($collection != null) {
			if (get_class($collection) == "ArrayCollection") {
				$result = $collection->toArray();
			} else {
				$result = $collection;
			}
		}
	}
	
	public function count() {
		return sizeof($this->_collection);
	}
	
	public function push($obj, $key = null) {
		$this->_collection[$key] = $obj;
	}
	
	public function toArray() {
		return $this->_collection;
	}
}

?>