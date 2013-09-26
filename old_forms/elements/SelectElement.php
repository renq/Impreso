<?php


class AF_SelectElement extends AF_Element {


	private $options;


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
		if (strlen($value)) {
			if (isset($this->options[$value])) {
				$this->value = $value;
			}
			else {
				foreach ($this->options as $opts) {
					if (is_array($opts) && isset($opts[$value])) {
						$this->value = $value;
						return;
					}
				}
				throw new AF_OutOfBoundsException("Option $value not found!");
			}
		}
	}


	public function setOptions($data) {
		$this->options = $data;
	}


	public function getOptions() {
		return $this->options;
	}


	public function show() {
		$attributesString = '';
		foreach ($this->getAttributes() as $k => $v) {
			if (!is_array($v) && $k != 'value') {
				$v = $this->valueEntities($v);
				$attributesString .= "$k=\"$v\" ";
			}
		}
		$attributesString = trim($attributesString);

		$html = <<<EOD
<select {$attributesString}>

EOD;

		if (is_array($this->getOptions())) {
			foreach ($this->getOptions() as $k => $v) {
				if (is_array($v)) {
					$html .= "<optgroup label=\"$k\">";
					foreach ($v as $k2 => $v2) {
						$selected = ($k2==$this->value && strlen($k2) == strlen($this->value)) ? 'selected="selected" ':'';
						$html .= "<option {$selected}value=\"" . $k2 . "\">$v2</option>\n";
					}
					$html .= "</optgroup>";
				}
				else {
					$selected = ($k==$this->value && strlen($k) == strlen($this->value))?'selected="selected" ':'';
					$html .= "<option {$selected}value=\"" . htmlentities($k, ENT_COMPAT, 'utf-8') . "\">$v</option>\n";
				}
			}
		}
		$html .= <<<EOD

</select>
EOD;
		return $html;

	}


}


