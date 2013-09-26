<?php


abstract class AF_Layout {

	private $form = null;
	
	
	public function __construct() {

	}
	
	
	public function getForm() {
		return $this->form;
	}
	
	
	public function show(AF_FormElement $form) {
		$this->form = $form;
		$html = '';
		
		$attrs = '';
		foreach ($form->getAttributes() as $k => $v) {
			$attrs .= " $k=\"$v\"";
		}
		
		$html .= "<form{$attrs}>\n";
		$html .= $this->showFormErrors();
		$html .= $this->showElements();
		$html .= "\n</form>";
		return $html;
	}
	
	protected abstract function showElements();

	
	protected function showFormErrors() {
		$errorList = '';
		$errors = $this->getForm()->getFormErrors();
		if (count($errors)) {
			foreach ($errors as $error) {
				$errorList .= '<li>'.$error.'</li>';
			}
			$errorList = "<ul class=\"formErrorList\">$errorList</ul>";
		}
		return $errorList;
	}
	
	
}


?>