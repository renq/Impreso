<?php


abstract class AF_Validator {
	
	
	protected $error = 'undefined error';
	
	
	public function __construct($error = '') {
		$this->setError($error);
	}
	
	
	abstract public function validate(AF_Element $element);
	
	
	public function getError() {
		return $this->error;
	}
	
	
	public function setError($message) {
		$this->error = $message;
	}
	
	
}


?>