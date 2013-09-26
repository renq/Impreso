<?php


class AF_PriceValidator extends AF_Validator {

	
	public function __construct($error = '') {
		parent::__construct($error);
		$error = strlen($error)?$error:'Price only';
		$this->setError($error);
	}
	
	
	public function validate(AF_Element $element) {
		return preg_match('/^[0-9]+$|^[0-9]+\.[0-9]{1,2}$/', $element->value)?true:false;
	}
	


}

