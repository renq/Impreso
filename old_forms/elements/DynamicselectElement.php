<?php


class AF_DynamicselectElement extends AF_SelectElement {


	public function setFromRequest() {
		$value = $this->getValueFromRequest();
		if (strlen($value)) {
			$this->value = $value;
		}
	}

//	public function setFromRequest() {
//		try {
//			parent::setFromRequest();
//		}
//		catch (AF_OutOfBoundsException $e) {
//
//		}
//	}


}


