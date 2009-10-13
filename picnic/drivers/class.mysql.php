<?php

class PicnicMySQLDriver {
	private $_mysqli;
	private $_lastResult;
	
	public function __construct() {
		
	}
	
	public function connect($dsn) {
		$this->_mysqli = mysqli_init();
		
		if (!$this->_mysqli) {
			throw new PicnicDatabaseConnectException("Running \"mysqli_init\" failed");
		}
		
		if (!$this->_mysqli->real_connect($dsn["host"], $dsn["user"], $dsn["pass"], ltrim($dsn["path"], '/'))) {
			throw new PicnicDatabaseConnectException("MySQL connection error ({mysqli_connect_errno()}) {mysqli_connect_error()}");
		}
	}
	
	public function query($sql) {
		$this->_lastResult = $this->_mysqli->query($sql);
		
		if (!$this->_lastResult) {
			throw new PicnicDatabaseQueryException("MySQL query error ({$this->_mysqli->errno}) {$this->_mysqli->error} ");
		}
	}
	
	public function numRows() {
		return $this->_lastResult->num_rows;
	}
	
	public function fetchObject() {
		return $this->_lastResult->fetch_object();
	}
	
	public function freeResult() {
		$this->_lastResult->close();
	}
	
	public function close() {
		$this->_mysqli->close();
	}
}

?>