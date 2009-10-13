<?php

class NetworkRequest {
	protected $_curl;
	protected $_result = null;
	
	public function __construct() {
		$this->_curl = curl_init();
	}
	
	public function set($url, array $params = null) {
		curl_setopt($this->_curl, CURLOPT_URL, $url);
		
		if ($params != null && sizeof($params) > 0) {
			foreach ($params as $key => $val) {
				curl_setopt($this->_curl, $key, $val);
			}
		}
		
	}
	
	public function execute() {
		$this->_result = curl_exec($this->_curl);
		
		return $this->_result;
	}
	
	public function close() {
		curl_close($this->_curl);
	}
	
	public function __deconstruct() {
		$this->close();
	}
}

?>