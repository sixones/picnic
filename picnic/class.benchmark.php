<?php

class PicnicBenchmark {
	private static $__results = array();
	
	public static function mark($name) {
		self::$__results[$name] = microtime();
	}
	
	public static function between($start, $end) {
		$startResult = null;
		$endResult = null;
		
		foreach (self::$__results as $name => $time) {
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
}

?>