<?php

class PicnicBenchmark {
	public $results = array();
	
	private static $__instance = null;
	
	public function mark($name) {
		$this->results[$name] = new PicnicBenchmarkMark();
	}
	
	public function getMark($name) {
		return $this->results[$name];
	}
	
	public function between($start, $end) {
		$startResult = null;
		$endResult = null;
		
		foreach ($this->results as $name => $time) {
			if ($name == $start) {
				$startResult = $time;
			} else if ($name == $end) {
				$endResult = $time;
			}
		}
		
		if ($startResult == null || $endResult == null) {
			throw new PicnicInvalidBenchmarkSet("You cannot find the time between to null points.");
		}
		
		return $endResult->microtime - $startResult->microtime;
	}
	
	public static function instance() {
		if (self::$__instance == null) {
			self::$__instance = new PicnicBenchmark();
		}
		
		return self::$__instance;
	}
}

class PicnicBenchmarkMark {
	public $microtime;
	public $timestamp;
	
	public function __construct() {
		$this->microtime = microtime();
		$this->timestamp = time();
	}
	
	public function getDateTime() {
		// PHP 5.3+ only
		//return DateTime::createFromFormat("U", $this->timestamp);
		
		//$time = date("F j, Y, g:i a", $this->timestamp);
		
		//return new DateTime($time);
		
		return PicnicDateTime::createFromTimestamp($this->timestamp);
	}
}

?>