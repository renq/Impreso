<?php


class AF_EmailValidator extends AF_Validator {


	
	public function __construct($error = '') {
		parent::__construct($error);
		$error = strlen($error)?$error:"Incorrect email address.";
		$this->setError($error);
	}
	
	
	public function validate(AF_Element $element) {
		return $this->verifyEmail($element->value);
	}
	

	/**
	 * Sprawdza poprawność adresu e-mail. Weryfikuje ciąg wyrażeniem regularnym
	 * oraz sprawdza rekord MX domeny (ale, o ile się nie mylę, tylko pod systemami
	 * operacyjnymi zgodnymi z POSIX (czyli praktycznie wszystkimi poza Windows).
	 * Funkcja z pl.comp.lang.php (z drobniutką modyfikacją)
	 *
	 * @param string $email
	 * @return bool
	 */
	protected function verifyEmail($email) {
		$wholeexp = '/^(.+?)@(([a-z0-9\.-]+?)\.[a-z]{2,6})$/i';
		$userexp = "/^[a-z0-9\~\!\#\$\%\&\(\)\-\_\+\=\[\]\;\:\'\"\,\.\/]+$/i";
		if (preg_match($wholeexp, $email, $regs)) {
			$username = $regs[1];
			$host = $regs[2];
			if (preg_match($userexp, $username)) {
				return true;
			}
		}
		return false;
	}
	
	
}


?>