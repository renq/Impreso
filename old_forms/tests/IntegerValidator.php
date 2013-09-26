<?php

require_once(dirname(__FILE__) . '/../../simpletest/autorun.php');
require_once(dirname(__FILE__) . '/../FormAutoload.php');


class TestOfIntegerValidator extends UnitTestCase {
	
	
	public function testStringValueInTextElement() {
		$validator = new AF_IntegerValidator('Not a integer');
		$textElement = new AF_TextElement();
		
		$textElement->value = 'somestring';
		$this->assertFalse($validator->validate($textElement));

		$textElement->value = '12xa';
		$this->assertFalse($validator->validate($textElement));
		
		$textElement->value = 'x166';
		$this->assertFalse($validator->validate($textElement));
	}
	
	
	public function testDecimalValueInTextElement() {
		$validator = new AF_IntegerValidator('Not a integer');
		$textElement = new AF_TextElement();
		
		$textElement->value = '10.3';
		$this->assertFalse($validator->validate($textElement));
		
		$textElement->value = '.3';
		$this->assertFalse($validator->validate($textElement));
		
		$textElement->value = '01211.';
		$this->assertFalse($validator->validate($textElement));
	}
	
	
}


?>