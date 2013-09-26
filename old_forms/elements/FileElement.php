<?php

//include_once('../other/IProcessFile.php');


class AF_FileElement extends AF_Element {
	
	
	
	public function __construct($label = false, $validators = array()) {
		parent::__construct($label, $validators);
		//$form=$this->getForm();
		//$form->enctype='multipart/form-data';
		//$this->setForm($form);
		//$this->form->enctype='multipart/form-data';
	}
	
	
	public function isSent() {
		$name = $this->getName();
		$data = $this->getForm()->getFileData();
		if (is_array($data[$name])) {
			return true;
		}
		return false;
	}

	
	public function setFromRequest() {
		$data = $this->getForm()->getRequest();
		if (array_key_exists($this->getName(), $data)) {
			$this->value = $data[$this->getName()];
		}		
	}
	
	
	public function show() {
		return <<<EOD
<input type="file" {$this->getAttributesString()} />
EOD;
		 
	}
	

}
 

?>