<?php

if (!class_exists('Template')) {
	die("Class Template is required.");
}

class AF_TemplateLayout extends AF_Layout {
	
	
	protected $tpl = null; 
	
	
	public function __construct($tplFile) {
		parent::__construct();
		$this->tpl = new Template($tplFile);
	}
	

	
	protected final function showElements() {
		$this->tpl->form = $this->getForm();
		$this->tpl->elements = $this->getForm()->getElements();
		return $this->tpl;
	}
	
	
	public function getTemplate() {
		return $this->tpl;
	}
	
	
}


?>