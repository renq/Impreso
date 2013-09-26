<?php


date_default_timezone_set('Europe/Warsaw');

error_reporting( E_ALL | E_STRICT );


include('../Form.php');



/*
* Klasa z naszym formularzem. Dziedziczymy po Form i dodajemy do niego pola.
*/
class PokemonRegisterForm extends AF_Form {


	public function __construct() {
		parent::__construct();

		$this->enctype = "multipart/form-data";

		$this->add('text', 'firstname', 'Imię: *', new AF_RequiredFieldValidator('Podaj swoje imię'));
		$this->add('text', 'secondname', 'Drugie imię')->value = 'ads';
		$this->add('text', 'lastname', 'Nazwisko: *', new AF_RequiredFieldValidator('Podaj swoje nazwisko'));
		$wojewodztwo = $this->add('select', 'province', 'Województwo', new AF_GreaterThanValidator(0, 'Wybierz województwo'));
		$wojewodztwo->setOptions(array(
			0 => 'wybierz',
			1 => 'dolnośląskie',
			2 => 'kujawsko-pomorskie',
			3 => 'lubelskie',
			4 => 'lubuskie',
			5 => 'łódzkie'
		));
		$wojewodztwo->value = 3;
		$this->add('text', 'city', 'Miasto');

		$rok = new AF_SelectElement('Rok urodzenia');
		$range = range(date('Y')-100, date('Y'));
		$daneRok = array(0 => '---') + array_reverse(array_combine($range, $range));
		$rok->setOptions($daneRok);
		$this->addElement('year', $rok);

		$daneMiesiac = array(
			'0' => '---',
			'1' => 'styczeń',
			'2' => 'luty',
			'3' => 'marzec',
			'4' => 'kwiecień',
			'5' => 'maj',
			'6' => 'czerwiec',
			'7' => 'lipiec',
			'8' => 'sierpień',
			'9' => 'wrzesień',
			'10' => 'październik',
			'11' => 'listopad',
			'12' => 'grudzień',
		);
		$miesiac = new AF_SelectElement('Miesiąc');
		$miesiac->setOptions($daneMiesiac);
		$this->addElement('month', $miesiac);

		$dzien = new AF_SelectElement('Dzień');
		$range = range(1, 31);
		$daneDzien = array(0 => '---') + array_combine($range, $range);
		$dzien->setOptions($daneDzien);
		$this->addElement('day', $dzien);

		$zdjecie = new AF_FileElement('Zdjęcie');
		$this->addElement('photo', $zdjecie);

		$email = new AF_TextElement('E-mail', new AF_EmailValidator('Podaj poprawny adres e-mail'));
		$this->addElement('email', $email);

		$password = new AF_PasswordElement('Hasło');
		$this->addElement('password', $password);

		$password2 = new AF_PasswordElement('Powtorz hasło');
		$this->addElement('password_confirm', $password2);

		$stanowisko = new AF_TextElement('Stanowisko');

		$branze = array(
			1 => 'Internet',
			2 => 'Telewizja',
			3 => 'Reklama',
			4 => 'Marketing'
		);
		foreach ($branze as $k => $v) {
			$this->addElement("industry[$k]", new AF_CheckboxElement($v));
		}

		$uczelnia = new AF_TextElement('Uczelnia');
		$this->addElement('education_school', $uczelnia);

		$kierunek = new AF_TextElement('Kierunek studiów');
		$this->addElement('education_major', $kierunek);

		$rodzaj = new AF_SelectElement('Rodzaj studiów');
		$rodzaj->setOptions(array(
			0 => '---wybierz---',
			1 => 'licencjat',
			2 => 'inżynierskie',
			3 => 'magisterskie',
			4 => 'uzupełniające',
			5 => 'doktoranckie'
		));
		$this->addElement('education_level', $rodzaj);

		$od = new AF_SelectElement('Od (rok)');
		$od->setOptions($daneRok);
		$this->addElement('education_year', $od);

		$od2 = new AF_SelectElement('Od (miesiąc)');
		$od2->setOptions($daneMiesiac);
		$this->addElement('education_month', $od2);

		$do = new AF_SelectElement('Do (rok)');
		$do->setOptions($daneRok);
		$this->addElement('education_year2', $do);

		$do2 = new AF_SelectElement('Do (miesiąc)');
		$do2->setOptions($daneMiesiac);
		$this->addElement('education_month2', $do2);

		$firma = new AF_TextElement('Firma');
		$this->addElement('company_name', $firma);

		$od = new AF_SelectElement('Od (rok)');
		$od->setOptions($daneRok);
		$this->addElement('company_year', $od);

		$od2 = new AF_SelectElement('Od (miesiąc)');
		$od2->setOptions($daneMiesiac);
		$this->addElement('company_month', $od2);

		$do = new AF_SelectElement('Do (rok)');
		$do->setOptions($daneRok);
		$this->addElement('company_year2', $do);

		$do2 = new AF_SelectElement('Do (miesiąc)');
		$do2->setOptions($daneMiesiac);
		$this->addElement('company_month2', $do2);

		$stanowisko = new AF_TextElement('Stanowisko');
		$this->addElement('company_job', $stanowisko);

		$obowiazki = new AF_TextareaElement('Zakres obowiązków');
		$this->addElement('company_duties', $obowiazki);

		$zgoda1 = new AF_CheckboxElement('Zgoda', new AF_CheckedValidator('Musisz wyrazić zgodę'));
		$this->addElement('zgoda1', $zgoda1);

		$zgoda2 = new AF_CheckboxElement('Zgoda 2', new AF_CheckedValidator('Musisz wyrazić zgodę 2'));
		$zgoda2->addTo($this, 'zgoda2');
		//$this->addElement('zgoda2', $zgoda2);

		$submit = new AF_SubmitElement();
		$this->addElement('wyslij', $submit);
	}


	protected function customValidator() {
		$return = true;
		if ($this->getElement('password')->value != $this->getElement('password_confirm')->value) {
			$this->getElement('password')->addError('Hasła muszą być jednakowe');
			$return = false;
		}
		return $return;
	}


}




$form = new PokemonRegisterForm();

/* kod poniżej jest roboczy, prawdopodobnie bedzie do zmiany na krotszy i taki, przy którym mniej trzeba myslec... */


if ($form->isSent()) {
	if ($form->validate()) {
		echo "<p>Formularz wyslany z SUKCESEM</p>";
		var_dump($form->getData());
		var_dump($form->getFileData());
	}
}

?>
<style>

.errorList {
	color: red;
}

</style>
<?php
echo $form->show(new AF_ParagraphLayout());



// test

?>