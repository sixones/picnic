<?php

class PicnicException extends Exception {
	public function __construct($message = "", $code = 0, $senderObject = null, $senderMethod = null, $exception = null) {
		// should pass parent $exception if PHP 5.3+
		parent::__construct($message, 0);
		
		$this->_senderObject = $senderObject;
		$this->_senderMethod = $senderMethod;
	}
	
	public function senderObject() { return $this->_senderObject; }
	public function senderMethod() { return $this->_senderMethod; }
}

class PicnicDiskWriteFailureException extends PicnicException { }

class PicnicUpdateRequiredException extends PicnicException { }

class PicnicMissingRequirementException extends PicnicException { }

class PicnicFactoryFileNotFound extends PicnicException { }

class PicnicRouteNotFoundException extends PicnicException { }

class PicnicTemplateNotDefinedException extends PicnicException { }

class PicnicNoDriverLoadedException extends PicnicException { }
class PicnicDriverCouldNotStartException extends PicnicException { }

class PicnicDatabaseException extends PicnicException { }
class PicnicDatabaseQueryException extends PicnicException { }

?>