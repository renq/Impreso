<?php


class AF_SubmitElement extends AF_Element {

	
	public function __construct($label = false, $validators = array()) {
		parent::__construct($label, $validators);
	}
	
	
	public function isSent() {
		return true;
	}
	
	
	public function setFromRequest() {
				
	}
	
	
	public function show() {
		return <<<EOD
<input class="submit" type="submit" {$this->getAttributesString()} />
EOD;
		 
	}
	

}
 

?>