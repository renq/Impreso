<?php


class AF_IntegerValidator extends AF_Validator {

	
	public function __construct($error = '') {
		parent::__construct($error);
		$error = strlen($error)?$error:'Integer only';
		$this->setError($error);
	}
	
	
	public function validate(AF_Element $element) {
		return preg_match('/^\-{0,1}[0-9]+$/', $element->value)?true:false;
	}
	

	
	
}


?>