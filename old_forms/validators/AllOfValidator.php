<?php


class AF_AllOfValidator extends AF_Validator {
	
	
	private $validators = array();
	
	
	public function __construct(array $validators, $error = '') {
		parent::__construct($error);
		$error = strlen($error)?$error:'';
		$this->setError($error);
		$this->validators = $validators;
	}
	
	
	public function validate(AF_Element $element) {
		$errors = array();
		foreach ($this->validators as $validator) {
			/* @var $validator AF_Validator */
			if (!$validator->validate($element)) {
				$errors[] = $validator->getError();
			}
		}
		if (!$this->getError()) {
			$this->setError(implode('<br />- ', $errors));
		}
		return empty($errors);
	}
	

	
	
}


?>