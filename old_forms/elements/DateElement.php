<?php


class AF_DateElement extends AF_Element {
	

	private $year;
	private $month;
	private $day;
	
	private $yearName = 'year';
	private $monthName = 'month';
	private $dayName = 'day';
	
	
	public function __construct($label = false, $validators = array()) {
		parent::__construct($label, $validators);
	}
	
	
	public function setYearName($name) {
		$this->yearName = $name;
		$this->year->setOptions(
				array('' => $this->yearName) + $this->getYearOptions()
		);
	}
	
	
	public function setMonthName($name) {
		$this->monthName = $name;
		$this->month->setOptions(
				array('' => $this->monthName) + $this->getMonthOptions()
		);
	}
	
	
	public function setDayName($name) {
		$this->dayName = $name;
		$this->day->setOptions(
				array('' => $this->dayName) + $this->getDayOptions()
		);
	}
	
	
	private function getYearOptions() {
		return array_combine(range(date('Y'), date('Y')-100), range(date('Y'), date('Y')-100));
	}

	
	private function getMonthOptions() {
		return array_combine(range(1, 12), range(1, 12));
	}
	
	
	private function getDayOptions() {
		return array_combine(range(1, 31), range(1, 31));
	}
	
	
	private function createYear() {
		$year = new AF_SelectElement();
		$year->setName($this->getName()."[year]");
		$year->setForm($this->getForm());
		$year->setOptions(
				array('' => $this->yearName) + $this->getYearOptions()
				);
		$this->year = $year;
	}
	
	
	private function createMonth() {
		$month = new AF_SelectElement();
		$month->setName($this->getName()."[month]");
		$month->setForm($this->getForm());
		$month->setOptions(
				array('' => $this->monthName) + $this->getMonthOptions()
				);
		$this->month = $month;
	}
	
	
	private function createDay() {
		$day = new AF_SelectElement();
		$day->setName($this->getName()."[day]");
		$day->setForm($this->getForm());
		$day->setOptions(
				array('' => $this->dayName) + $this->getDayOptions()
				);
		$this->day = $day;
	}
	
	
	public function isSent() {
		if ($data = $this->getForm()->getRequest()) {
			if (array_key_exists($this->getName(), $data)) {
				return true;
			}
		}
		return false;
	}
	

	public function setFromRequest() {
		$this->year->setFromRequest();
		$this->month->setFromRequest();
		$this->day->setFromRequest();
	}
	
	
	public function setForm(AF_FormElement $form) {
		parent::setForm($form);
		$this->createYear();
		$this->createMonth();
		$this->createDay();
	}
		
	
	public function show() {
		return <<<EOD
		{$this->year}
		{$this->month}
		{$this->day}
EOD;
	}
	
	
	public function get($attribute) {
		if ($attribute == 'value') {
			if (!$this->year->value || !$this->month->value || !$this->day->value) return '';
			return $this->year->value . '-' . substr('0'.$this->month->value, -2) . '-' . substr('0'.$this->day->value, -2);
		}
		else {
			parent::get($attribute);
		}
	}
	
	
	public function set($attribute, $value) {
		if ($attribute == 'value') {
			if (strlen($value)) {
				list($y, $m, $d) = explode('-', $value);
				$this->year->value = (int)$y;
				$this->month->value = (int)$m;
				$this->day->value = (int)$d;
			}
		}
		else {
			parent::set($attribute, $value);
		}
	}
	

}
 

