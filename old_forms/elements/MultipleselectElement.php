<?php


class AF_MultipleselectElement extends AF_SelectElement {



	public function __construct($label = false, $validators = array()) {
		parent::__construct($label, $validators);
	}



	public function setFromRequest() {
		$data = $this->getForm()->getRequest();
		$requestKey = preg_replace('/\[\]$/', '', $this->getName());
		if (array_key_exists($requestKey, $data)) {
			$this->value = $data[$requestKey];
		}
	}


	public function isSent() {
		return true;
	}


	public function show() {
		$html = <<<EOD
<select multiple="multiple" {$this->getAttributesString()}>

EOD;
		foreach ($this->getOptions() as $k => $v) {
			$values = is_array($this->value)?$this->value:array();
			$selected = in_array($k, $values)?'selected="selected" ':'';
			$html .= "<option {$selected}value=\"{$k}\">{$v}</option>\n";
		}
		$html .= <<<EOD

</select>
EOD;
		return $html;

	}


}


?>