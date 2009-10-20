<?php

class PicnicException extends Exception {
	public function __construct($message = "", $code = 0, $senderObject = null, $senderMethod = null, $exception = null) {
		parent::__construct($message, $code, $exception);
		
		$this->_senderObject = $senderObject;
		$this->_senderMethod = $senderMethod;
	}
	
	public function senderObject() { return $this->_senderObject; }
	public function senderMethod() { return $this->_senderMethod; }
}

class PicnicDiskWriteFailureException extends PicnicException { }

class PicnicMissingRequirementException extends PicnicException { }

class PicnicFactoryFileNotFound extends PicnicException { }

class PicnicRouteNotFoundException extends PicnicException { }

class PicnicTemplateNotDefinedException extends PicnicException { }

class PicnicNoDriverLoadedException extends PicnicException { }
class PicnicDriverCouldNotStartException extends PicnicException { }

class PicnicDatabaseException extends PicnicException { }
class PicnicDatabaseQueryException extends PicnicException { }

?>