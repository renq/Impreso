<?php


class AF_LessThanValidator extends AF_Validator {

	private $lt; 
	
	
	public function __construct($lt, $error = '') {
		parent::__construct($error);
		$this->lt = $lt;
		$error = strlen($error)?$error:"Value must be less than $lt.";
		$this->setError($error);
	}
	
	
	public function validate(AF_Element $element) {
		return $element->value < $this->lt;
	}
	

	
	
}


?>