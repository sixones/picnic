<?php

class PicnicUtils {
	public static function dump($object) {
		echo "<pre>";
		var_dump($object);
		echo "</pre>";
	}
	
	public static function getIndex($array, $index) {
		return $array[$index];
	}
	
	public static function isAssociativeArray($array) {
		return (is_array($array) && 0 !== count(array_diff_key($array, array_keys(array_keys($array)))));
	}
	
	public static function random() {
		srand(self::randomSeed());
		
		return rand();
	}
	
	public static function randomSeed() {
		list($usec, $sec) = explode(" ", microtime());
		
		return (float)$sec + ((float) $usec * 100000);
	}
	
	public static function trim($str, $chars = null) {
		return rtrim(ltrim($str, $chars), $chars);
	}
	
	public static function implode($str, $join = ", ") {
		return self::trim(implode($str, $join));
	}
	
	public static function mkdirR($dirName, $rights = 0777) {
		$dirs = explode('/', $dirName);
	    $dir='';
	
	    foreach ($dirs as $part) {
	        $dir.=$part.'/';
	        if (!is_dir($dir) && strlen($dir)>0)
	            mkdir($dir, $rights);
	    }
	}
	
	function mkdir_r($dirName, $rights=0777){

	}
}

?>