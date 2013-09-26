<?php


class AF_GreaterThanElementValidator extends AF_Validator {

	private $element;


	public function __construct(AF_Element $element, $error = '') {
		parent::__construct($error);
		$this->element = $element;
		$error = strlen($error)?$error:"Value must be greater than '{$element->value}'.";
		$this->setError($error);
	}


	public function validate(AF_Element $element) {
		return $element->value > $this->element->value;
	}


}

