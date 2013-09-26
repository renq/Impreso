<?php


class AF_RequiredFieldValidator extends AF_Validator {

	
	public function __construct($error = '') {
		parent::__construct($error);
		$error = strlen($error)?$error:'Field is required';
		$this->setError($error);
	}
	
	
	public function validate(AF_Element $element) {
		$value = $element->value;
		return (is_array($value) ? (bool)count($value) : strlen($value)) ? true : false;
	}
	

	
	
}


?>