<?php

require_once(dirname(__FILE__) . '/../../simpletest/autorun.php');
require_once(dirname(__FILE__) . '/../FormAutoload.php');


class TestOfEmailValidator extends UnitTestCase {
	
	
	public function testCorrectEmailAddresses() {
		$validator = new AF_EmailValidator('Not a email!');
		$textElement = new AF_TextElement();
		
		$textElement->value = 'spam@lipek.net';
		$this->assertTrue($validator->validate($textElement));

		$textElement->value = 'renq@o2.pl';
		$this->assertTrue($validator->validate($textElement));
		
		$textElement->value = 'michallipek@gmail.com';
		$this->assertTrue($validator->validate($textElement));
	}
	
		
}


?>