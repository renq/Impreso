<?php

date_default_timezone_set('Europe/Warsaw');
session_start();
error_reporting( E_ALL | E_STRICT );


include('../Form.php');



/*
* Klasa z naszym formularzem. Dziedziczymy po Form i dodajemy do niego pola.
*/
class Test04Form extends AF_Form {
		
	
	public function __construct() {
		parent::__construct();
		
		$this->action = "test04_save.php";
		
		$this->add('text', 'name', 'Name: *', new AF_RequiredFieldValidator('Name is required!'))->set('style', 'border: 2px solid blue;');
		$this->add('text', 'city', 'City:');
	
		$this->add('submit', 'send')->value = 'send';
	}
	
	
	protected function customValidator() {
		$return = true;
		if (count($this->getErrors())) {
			$this->addFormError('Custom error!');
			$return = false;
		}
		return $return;
	}
	
	
}


?>