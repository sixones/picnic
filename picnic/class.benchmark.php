<?php

class PicnicBenchmark {
	public $results = array();
	
	private static $__instance = null;
	
	public function mark($name) {
		$this->results[$name] = microtime();
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
		
		return $endResult - $startResult;
	}
	
	public static function instance() {
		if (self::$__instance == null) {
			self::$__instance = new PicnicBenchmark();
		}
		
		return self::$__instance;
	}
}

?>