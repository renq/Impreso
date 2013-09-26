<?php


class AF_AnyOfValidator extends AF_Validator {
	
	
	private $validators = array();
	
	
	public function __construct(array $validators, $error = '') {
		parent::__construct($error);
		$error = strlen($error)?$error:'Any of validator...';
		$this->setError($error);
		$this->validators = $validators;
	}
	
	
	public function validate(AF_Element $element) {
		$result = false;
		foreach ($this->validators as $validator) {
			if ($validator->validate($element)) {
				$result = true;
			}
		}
		return $result;
	}
	

	
	
}


?>