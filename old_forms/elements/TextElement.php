<?php


class AF_TextElement extends AF_Element {


	public function __construct($label = false, $validators = array()) {
		parent::__construct($label, $validators);
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
		$value = $this->getValueFromRequest();
		if ($value != '') {
			$this->value = $value;
		}
	}


	public function show() {
		return <<<EOD
<input type="text" {$this->getAttributesString()} />
EOD;
	}


}


?>