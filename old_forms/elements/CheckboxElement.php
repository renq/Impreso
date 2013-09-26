<?php


class AF_CheckboxElement extends AF_Element {

	
	public function __construct($label = false, $validators = array()) {
		parent::__construct($label, $validators);
	}
	
	
	public function isSent() {
		return true;
	}
	
	
	public function setFromRequest() {
		$value = $this->getValueFromRequest();
		if (strlen($value)) {
			$this->value = $value;
		}
	}
	
	
	public function show() {
		if ($this->value) {
			$this->checked = "checked";
		}
		$this->value = 1;
		return <<<EOD
<input type="hidden" value="0" name="{$this->getHtmlName()}" />
<input type="checkbox" {$this->getAttributesString()} />
EOD;
		 
	}
	

}
 

?>