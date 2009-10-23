<?php

if (!defined("PICNIC_DIR")) define("PICNIC_DIR", "");

define("PICNIC", "0.2.4");

require_once(PICNIC_DIR . "class.exceptions.php");

set_exception_handler("Picnic::exceptionHandler");
set_error_handler("Picnic::errorHandler", E_ALL);

require_once(PICNIC_DIR . "utils/class.array.php");
require_once(PICNIC_DIR . "utils/class.functions.php");
require_once(PICNIC_DIR . "utils/class.networkrequest.php");
require_once(PICNIC_DIR . "utils/class.xmlparser.php");

//require_once(PICNIC_DIR . "vendors/phpDataMapper/Model.php");
//require_once(PICNIC_DIR . "vendors/phpDataMapper/Model/Row.php");
//require_once(PICNIC_DIR . "vendors/phpDataMapper/Database/Adapter/Mysql.php");

require_once(PICNIC_DIR . "class.base.php");

require_once(PICNIC_DIR . "class.application.php");
require_once(PICNIC_DIR . "class.benchmark.php");
require_once(PICNIC_DIR . "class.configuration.php");
require_once(PICNIC_DIR . "class.controller.php");
require_once(PICNIC_DIR . "class.factory.php");
require_once(PICNIC_DIR . "class.model.php");
require_once(PICNIC_DIR . "class.router.php");
require_once(PICNIC_DIR . "class.view.php");

PicnicBenchmark::instance()->mark("start");

class Picnic {
	private $_controller;
	private $_currentRoute;
	private $_currentRequestUrl = null;
	private $_router;
	private $_view;
	
	private $_databaseAdapter;
	private $_pdo;
	
	private $_applications;
	
	private static $__instance;
	
	public static function exceptionHandler($ex) {
		include("views/exception.html");
	}
	
	public static function errorHandler($code, $message, $file, $line) {
		throw new ErrorException($message, 0, $code, $file, $line);
	}
	
	public function __construct() {
		$this->_applications = array();
		
		$this->_router = new PicnicRouter();
	}
	
	public function mock($path) {
		$this->_currentRequestUrl = $path;
	}
	
	public function controller() {
		return $this->_controller;
	}
	
	public function currentRoute() {
		return $this->_currentRoute;
	}
	
	public function databaseAdapter() {
		return $this->_databaseAdapter;
	}
	
	public function router() {
		return $this->_router;
	}
	
	public function view() {
		return $this->_view;
	}
	
	public function loadApplication($path) {
		$app = PicnicApplication::loadApplication($path);
		
		$this->_applications[] = $app;
		
		/*if (is_dir($path)) {
			if (file_exists($path."setup.php")) {
				require_once($path."setup.php");
				
				$r = $this->router();
				
				require_once($path."config".DS."routes.php");
			}
		}*/
	}
	
	public function loadDatabaseAdapter($dsn, array $options = null) {
		$source = parse_url($dsn);
		$database = ltrim($source["path"], '/');
		// array(PDO::ATTR_PERSISTENT => true)
		$pdoDSN = "{$source["scheme"]}:dbname={$database};host={$source["host"]}";
		
		try {
			if ($source["scheme"] == "mysql") {
				//$this->_databaseAdapter = new phpDataMapper_Database_Adapter_Mysql($source["host"], $database, $source["user"], $source["pass"]);
			} else {
				throw new PicnicDatabaseException("Database adapter type '{$dsn["scheme"]}' not supported.", 0, "Picnic", "loadDatabaseAdapter");
			}
		} catch (Exception $ex) {
			throw new PicnicDatabaseException($ex->getMessage(), 0, "Picnic", "loadDatabaseAdapter", $ex);
		}
	}
	
	public function render() {
		if (isset($_REQUEST["req"]) && $_REQUEST["req"] != null) {
			$this->mock($_REQUEST["req"]);
		}
		
		if ($this->_currentRequestUrl == null) {
			$this->_currentRequestUrl = $_SERVER["REQUEST_URI"];
		}
		
		$this->_currentRoute = $this->router()->findRouteFor($this->_currentRequestUrl);
		
		if ($this->_currentRoute == null)
		{
			throw new PicnicRouteNotFoundException("A route could not be found for `{$_SERVER["REQUEST_URI"]}`", 0, "PicnicRouter", "render");
		}
		
		$controllerName = $this->currentRoute()->controller();

		$this->_controller = new $controllerName();
		$this->_controller->call($this->currentRoute()->action());
		
		$this->_view->render($this->controller()->result());
	}
	
	public static function getInstance() {
		if (self::$__instance == null) {
			self::$__instance = new Picnic();
			self::$__instance->_view = new PicnicView();
		}
		
		return Picnic::$__instance;
	}
}

?>