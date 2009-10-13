<?php

class PicnicDatabase {
	protected $_driver;
	protected $_queries;
	protected $_dsn;
	
	public function queries() {
		return $this->_queries;
	}
	
	public function __construct() {
		$this->_queries = new ArrayCollection();
	}
	
	public function connect($dsn) {
		// parse dsn
		$this->_dsn = parse_url($dsn);
		// create driver
		switch ($this->_dsn["scheme"]) {
			case "mysql":
				$this->_driver = new PicnicMySQLDriver();
			break;
			case "sqlite":
				$this->_driver = new PicnicSQLiteDriver();
			break;
			default:
				throw new PicnicInvalidArgumentException("The database driver \"{$this->_dsn["scheme"]}\" could be not found.", 0, "PicnicDatabase", "connect");
			break;
		}
		// connect driver
		if ($this->_driver != null) {
			$this->_driver->connect($this->_dsn);
		} else {
			throw new PicnicDriverCouldNotStartException("The database driver \"{$this->_dsn["scheme"]}\" could not start successfully.", 0, "PicnicDatabase", "connect");
		}
	}
	
	public function query($sql) {
		if ($this->_driver == null) throw new PicnicNoDriverLoadedException("", 0, "PicnicDatabase", "query");
		// forward to driver
		
		$this->_queries->push($sql);
		
		$this->_driver->query($sql);
	}
	
	public function fetchObject() {
		return $this->_driver->fetchObject();
	}
	
	public function numRows() {
		return $this->_driver->numRows();
	}
}

?>