<?php if (!defined("PICNIC")) { header("Location: /"); exit(1); }

class PicnicView {
	private $_picnic;
	private $_smarty;
	
	private $_layoutTemplatePath = "layouts/application.html";
	private $_templateFolder;
	private $_template;

	public function __construct() {
		$this->_picnic = Picnic::getInstance();
	}
	
	public function picnic() {
		return $this->_picnic;
	}
	
	public function layoutTemplatePath() {
		return $this->_layoutTemplatePath;
	}
	
	public function layoutPath() {
		return $this->_templateFolder .DS. $this->_layoutTemplatePath;
	}
	
	public function templatePath() {
		return $this->_templateFolder .DS. $this->_template;
	}
	
	public function useTemplate($tpl) {
		$this->_template = $tpl;
	}
	
	public function useTemplateFolder($path) {
		$this->_templateFolder = $path;
	}
	
	public function render($data) {
		$type = $this->picnic()->router()->outputType();

		if ($type == "xml") {
			PicnicBenchmark::mark("end");
			
			header("Content-type: text/xml");
			echo PicnicXMLParser::objects2XML($this->picnic()->controller());
			exit();
		} else if ($type == "json") {
			header("Content-type: text/x-javascript");
			echo json_encode($this->picnic()->controller());
			exit();
		} else { 
			if ($this->_template == null) {
				throw new PicnicTemplateNotDefinedException("No template has been defined to use", 0, "PicnicView", "render");
			}

			if (file_exists($this->templatePath())) {
				$contents = $this->getTemplateContents($this->templatePath());
			
				if ($contents === false) {
					exit("TEMPLATE ERROR");
				}
			
				PicnicBenchmark::mark("end");
			
				if ($this->layoutTemplatePath() != "" && file_exists($this->layoutTemplatePath())) {
					// TODO: use getTemplateContents()
					include($this->layoutTemplatePath());
				} else {
					echo $contents;
				}
			} else {
				throw new PicnicTemplateNotDefinedException("The template '{$this->_template}' does not exist in the template path '{$this->_templateFolder}'", 0, "PicnicView", "render");
			}
		}
	}
	
	public function getTemplateContents($file) {
		if (is_file($file)) {
			ob_start();
			
			include($file);
			
			$contents = ob_get_contents();
			
			ob_end_clean();
			
			return $contents;
		}
		
		return false;
	}
}

?>