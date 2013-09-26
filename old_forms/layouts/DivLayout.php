<?php


class AF_DivLayout extends AF_Layout {
	
	
	public function __construct() {
		parent::__construct();
	}
	

	
	protected final function showElements() {
		$elements = $this->getForm()->getElements();
		
		$result = '';
		foreach ($elements as $element) {
			if ($element instanceof AF_HiddenElement) {
				$result .= $element->show();
			}
			else {
				$label = '';
				if (strlen($element->getLabel())) {
					$label = "<label for=\"{$element->id}\">{$element->getLabel()}</label>";
				}
				$errorList = '';
				$errors = $element->getErrors();
				if (count($errors)) {
					foreach ($errors as $error) {
						$errorList .= '<li>'.$error.'</li>';
					}
					$errorList = "<ul class=\"errorList\">$errorList</ul>";
				}
				$result .= <<<EOD
<div>
	{$label}
	{$element->show()}
	{$errorList}
</div>

EOD;
			}
		}
		return $result;
	} 
	
	
}


?>