<?php

date_default_timezone_set('Europe/Warsaw');

error_reporting( E_ALL | E_STRICT );


include('../Form.php');



/*
* Klasa z naszym formularzem. Dziedziczymy po Form i dodajemy do niego pola.
*/
class CustomLayoutForm extends AF_Form {


	public function __construct() {
		parent::__construct();

		$this->add('text', 'name', 'Name: *', new AF_RequiredFieldValidator('Name is required!'));
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




$form = new CustomLayoutForm();


if ($form->isSent()) { // jeżeli wysłano
	if ($form->validate()) { // i zwalidowano
		// sukces
		echo "<p>Formularz wyslany z SUKCESEM</p>";
		var_dump($form->getData());
		var_dump($form->getFileData());
	}
}
// nie wysłano bądź walidacja się nie udała

?>

<span style="color: red"><?=implode('<br>', $form->getFormErrors())?></span>
<br>
<form action="<?=$form->action?>" method="<?=$form->method?>">
	<div><?=$form->getElement('name')->getLabel()?>
		<?=$form->getElement('name')?>
		<span style="color: red"><?=implode('<br>', $form->getElement('name')->getErrors())?></span>
	</div>
	<div><?=$form->getElement('city')->getLabel()?>
		<?=$form->getElement('city')?>
	</div>
	<?=$form->getElement('send')?>
</form>

