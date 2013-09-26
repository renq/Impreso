<?php


error_reporting( E_ALL | E_STRICT );


include('../Form.php');



/*
* Klasa z naszym formularzem. Dziedziczymy po Form i dodajemy do niego pola.
*/
class SimpleInputForm extends AF_FormElement {
	
	
	public function __construct() {
		parent::__construct();
		
		$this->enctype = "multipart/form-data";
		

		$this->setName('test'); // zmiana nazwy formularza (opcja)

		$this->addElement('name', 
			new AF_TextElement('Your name:', array(
				new AF_RequiredFieldValidator('Name is required!')
			))
		); // dodanie inputa do formatki
		
		$this->addElement('bluzgi', 
			new AF_TextareaElement('Bluzgi:')
		); // dodanie inputa do formatki

		$this->addElement('integer', 
			new AF_TextElement('Integer only:', array(
				new AF_IntegerValidator('Integer only!')
			))
		); //dodanie do formatki
		
		$this->addElement('check', 
			new AF_CheckboxElement('Check me: ', array(
				new AF_CheckedValidator('Please check me!')
			))
		);
		
		$select = new AF_SelectElement('Yes or no?');
		$select->setOptions(array(
			0 => '--- wybierz ---',
			1 => 'tak',
			2 => 'nie',
		));
		$this->addElement('choice', $select);
		
		$hidden = new AF_HiddenElement();
		$hidden->value="you can't see me";
		$this->addElement('hidden', $hidden);
		
		$radios = new AF_RadioSetElement('Yes or no?', array(new AF_RequiredFieldValidator('Zaznacz jedna z opcji')));
		$radios->setOptions(array(
			'0' => 'no',
			'1' => 'yes', 
		));
		$this->addElement('radios', $radios);
		
		$jpeg = new AF_FileElement('JPEG file', array(new AF_FileExistsValidator('Daj jakies fajne zdjecie!')));
		$this->addElement('image', $jpeg);
		
		$multipleSelect = new AF_MultipleSelectElement('Fruit I Like');
		$multipleSelect->setOptions(array(
			1 => 'apple',
			2 => 'banana',
			3 => 'peach',
			4 => 'lemon'
		));
		$this->addElement('fruit', $multipleSelect);
		
		$submit = new AF_SubmitElement(); // nowy submit
		$submit->value = 'Send'; // tekst w submicie
		$this->addElement('send', $submit); // dodanie do formatki
		
		// ustalenie domyslnych wartosci... Podajemy tablice gdzie kluczami sa nazwy elementow, a wartosciami wartosci... 
		// Dla samego anything mozna też zmienic value inaczej. Np. tak:
		// $anything->value = 'Say anything';
		$this->setData(array(
			'check'		=> 1,
		));
	}


}


$form = new SimpleInputForm();

/* kod poniżej jest roboczy, prawdopodobnie bedzie do zmiany na krotszy i taki, przy którym mniej trzeba myslec... */

$form->start();
if ($form->isSent()) {
	if ($form->validate()) {
		echo "<p>Formularz wyslany z SUKCESEM</p>";
		var_dump($form->getData());
		var_dump($form->getFileData());
	}
}

echo $form->show(new AF_ParagraphLayout());



?>