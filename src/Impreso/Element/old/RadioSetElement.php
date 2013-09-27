<?php


class AF_RadioSetElement extends AF_Element {
	
	
	private $options;

	
	public function __construct($label = false, $validators = array()) {
		parent::__construct($label, $validators);
	}
	
	
	public function isSent() {
		return true;
	}
	
	
	public function setFromRequest() {
		if ($value = $this->getValueFromRequest()) {
			$this->value = $value;
		}
	}
	
	
	public function setOptions($data) {
		$this->options = $data;
	}
	
	
	public function getOptions() {
		return $this->options;
	}
	
	
	public function show() {
		$html = <<<EOD
<ul {$this->getAttributesString()}>

EOD;
		$i = 0;
		foreach ($this->getOptions() as $k => $v) {
			$id = $this->id;
			$selected = ($k==$this->value && strlen($k) == strlen($this->value))?'checked="checked" ':'';
			$html .= <<<EOD

	<li><input type="radio" {$this->getAttributesString(array('id', 'value', 'name'))} name="{$this->getHtmlName()}" value="{$k}" id="{$id}{$i}" {$selected}/> {$v}</li> 
EOD;
			$i = (int)$i + 1;
		}
		$html .= <<<EOD

</ul>
EOD;
		return $html;
		 
	}
	

}
 

?>