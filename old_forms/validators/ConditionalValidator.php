<?php
/**
 * Created by JetBrains PhpStorm.
 *  
 * Date: 28.07.11 10:52
 *
 * ConditionalValidator buduje się w taki sposob:
 *
 * $this->add('text', 'email', 'Adres e-mail', new AF_ConditionalValidator(array(
 * 		"if" => new AF_EmptyStringValidator(),
 * 		"then" => new AF_EmailValidator()), "Niepoprawny format e-mail"));
	));
 *
 * array $conditions zawiera dwa elementy tablicy - 'if' oraz 'then'.
 * To oznacza, ze walidator 'then' wykona się tylko gdy 'if' zwróci true,
 * w przeciwnym wypadku nie bedzie sie wykonywał (tj zwroci true)
 *
 * @author Jacek Jakubik <j.jakubik@goldensubmarine.com>
 */

class AF_ConditionalValidator extends AF_Validator {

	private $conditions = null;

	public function __construct(array $conditions, $error = '') {
		parent::__construct($error);
		$error = strlen($error)?$error:'Field error.';
		$this->setError($error);

		$this->conditions = $conditions;
	}


	public function validate(AF_Element $element) {
		$if_validator = $this->conditions['if'];
		$then_validators = $this->conditions['then'];

		if ($if_validator->validate($element) == TRUE) {
			return $then_validators->validate($element);
		} else {
			return TRUE;
		}
	}
}