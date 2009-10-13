<?php

class StandardObject {
	
}

class PicnicXMLParser {
	private $_xml;
	private $_data;
	
	private $_reader;
	private $_writer;
	
	public static function objects2XML($data) {
		$parser = new PicnicXMLParser();
		$parser->loadObjects($data);
		
		$parser->write();
		
		return $parser->getXML();
	}
	
	public function getXML() {
		return $this->_xml;
	}
	
	public function loadXML($xml) {
		$this->_xml = $xml;
	}
	
	public function loadXMLFile($path) {
		$node = new SimpleXMLElement($path, null, true);
		
		$this->_xml = $node->asXML();
	}
	
	public function loadObjects($data) {
		$this->_data = $data;
	}
	
	public function writeXMLFile($path) {
		if ($this->_xml == null) {
			throw new PicnicMissingRequirementException("No XML data could be found, write some objects to XML with write() first.", 0, "PicnicXMLParser", "writeXMLFile");
		}
		
		$writer = new XMLWriter();
		$writer->openURI($path);
		$writer->writeRaw($this->_xml);
		$writer->flush();
	}
	
	public function read() {
		if ($this->_xml == "") {
			throw new PicnicMissingRequirementException("No XML data could be found, use loadXML() or loadXMLFile() before trying to read.", 0, "PicnicXMLParser", "read");
		}
		
		$reader = new SimpleXMLElement($this->_xml);
		$results = $this->readNode($reader, array());
		
		$this->_data = array_pop($results);
		
		return $this->_data;
	}
	
	public function write() {
		if ($this->_data == "") {
			throw new PicnicMissingRequirementException("No objects could be found, use loadObjects() before trying to write to XML.", 0, "PicnicXMLParser", "write");
		}
		
		$writer = new XMLWriter();
		$writer->openMemory();
		
		$writer->startDocument("1.0", "utf-8");
		$writer->setIndent(4);
		
		if (is_array($this->_data) && sizeof($this->_data) > 0) {
			$keys = array_keys($this->_data);
			
			$key = $keys[0];
			//$this->_data = $this->_data[$key];
		} else if (is_object($this->_data)) {
			$key = get_class($this->_data);
		}
		
		$this->writeNode($writer, "data", $this->_data);
		
		$writer->endDocument();
		$this->_xml = $writer->outputMemory(false);
		
		return $writer;
	}
	
	public static function findAttribute($object, $search) {
		foreach ($object->attributes() as $key => $val) {
			if ($key == $search) {
				return $val;
			}
		}
		
		return null;
	}
	
	protected function readNode($xml, $results) {
		if (sizeof($xml->children()) != 0) {
			$children = array();
			
			$type = (string)self::findAttribute($xml, "class");
			
			foreach ($xml->children() as $node) {
				$type2 = (string)self::findAttribute($node, "class");
				
				if (sizeof($node->children()) > 0) {
					
					if ($type == "array") {
						$result = $this->readNode($node, array());
						$children[] = array_pop($result);
					} else {
						$children = array_merge($children, $this->readNode($node, array()));
					}
				} else {
					if ($type2 == "array") {
						$children[] = array();//(string)$node;
					} else {
						$children[$node->getName()] = (string)$node;
					}
					
				}
			}

			if ($type != null) {
				if ($type == "object") {
					$obj = new StandardObject();
				
					foreach ($children as $key => $val) {
						$obj->$key = $val;
					}
				
					$children = $obj;
				} else if ($type == "array") {
					
				} else {
					$obj = new $type();
					
					foreach ($children as $key => $val) {
						$obj->$key = $val;
					}
				
					$children = $obj;
				}
			}
			
			$results[$xml->getName()] = $children;
		} else {
			$results[$xml->getName()] = (string)$xml;
		}
		
		return $results;
	}
	
	protected function writeNode($writer, $key, $node) {
		$writer->startElement($key);
		
		if (is_object($node)) {
			$writer->writeAttribute("class", get_class($node));
		} else if (is_array($node)) {
			$keys = array_keys($node);
			if (!PicnicUtils::isAssociativeArray($node)) {
				$writer->writeAttribute("class", "array");
			}
		}
		
		if (is_array($node) || is_object($node)) {
			foreach ($node as $key2 => $val) {
				if (($key2 == null || is_int($key2)) && !is_string($val) && !is_array($val)) {
					$key2 = get_class($val);
				} else if (!is_string($key2) && is_string($val) || is_numeric($key2)) {
					$key2 = "string";
				}

				if (is_array($val)) {
					$this->writeNode($writer, $key2, $val);
				} else {
					$this->writeNode($writer, $key2, $val);
				}
			}
		} else {
			$writer->text($node);
		}
		
		$writer->fullEndElement();
	}
}



?>