<?php


class AF_PasswordElement extends AF_TextElement {

	
	public function __construct($label = false, $validators = array()) {
		parent::__construct($label, $validators);
	}
	
	
	public function show() {
		return <<<EOD
<input type="password" {$this->getAttributesString()} />
EOD;
		 
	}
	

}
 

?>