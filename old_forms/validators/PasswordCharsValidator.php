<?php


class AF_PasswordCharsValidator extends AF_Validator {


	private $numberOfBigLetters;
	private $numberOfSmallLetters;
	private $numberOfDigits;
	private $numberOfSpecialChars;
	private $element;


	public function __construct($error = '', $numbersOfSmallLetters = 1, $numberOfBigLetters = 1, $numberOfDigits = 1, $numberOfSpecialChars = 0) {
		parent::__construct($error);
		$error = strlen($error)?$error:"Passwords must have at least: {$numbersOfSmallLetters} small letters; {$numberOfBigLetters} big letters; {$numberOfDigits} digits and {$numberOfSpecialChars} special characters.";
		$this->setError($error);

		$this->numberOfSmallLetters = $numbersOfSmallLetters;
		$this->numberOfBigLetters = $numberOfBigLetters;
		$this->numberOfDigits = $numberOfDigits;
		$this->numberOfSpecialChars = $numberOfSpecialChars;
	}


	public function validate(AF_Element $element) {
		$this->element = $element;
		return $this->checkBigLetters() && $this->checkSmallLetters() && $this->checkDigits() && $this->checkSpecialChars();
	}


	private function checkBigLetters() {
		return $this->check('/[A-Z]/', $this->numberOfBigLetters);
	}


	private function checkSmallLetters() {
		return $this->check('/[a-z]/', $this->numberOfSmallLetters);
	}


	private function checkDigits() {
		return $this->check('/[0-9]/', $this->numberOfDigits);
	}


	private function checkSpecialChars() {
		return $this->check('/[^A-Z0-9a-z]/', $this->numberOfSpecialChars);
	}


	private function check($regex, $numberOf) {
		if ($numberOf < 1) {
			return true;
		}
		$matches = array();
		if (preg_match_all($regex, $this->element->value, $matches)) {
			if (count($matches[0]) >= $numberOf) {
				return true;
			}
		}
		return false;
	}


}


