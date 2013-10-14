<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 09.10.13
 * Time: 14:20
 */

namespace Tests\Impreso\Validator;


use Impreso\Validator\CustomValidator;

class CustomValidatorTest extends \PHPUnit_Framework_TestCase
{

    public $outsideVariable;

    public function testValidator()
    {
        $validator = new CustomValidator();
        $validator->setFunction(function($v) {
            return $v;
        });

        $this->assertTrue($validator->validate(1));
        $this->assertTrue($validator->validate(true));
        $this->assertTrue($validator->validate('ok'));

        $this->outsideVariable = true;
        $self = $this;
        $validator->setFunction(function ($v) use ($self) {
            return $v && $self->outsideVariable;
        });

        $this->assertTrue($validator->validate(true));
        $this->assertFalse($validator->validate(false));

        $this->outsideVariable = false;
        $this->assertFalse($validator->validate(true));
        $this->assertFalse($validator->validate(false));
    }

    public function testPHPFunctions()
    {
        $validator = new CustomValidator('error', 'is_array');
        $this->assertTrue($validator->validate(array(1)));

        $dom = new \DOMDocument('1.0', 'utf-8');
        $element = $dom->createElement('p', 'Lorem ipsum...');
        $element->setAttribute('impreso', 'awesome');
        $validator->setFunction(array($element, 'hasAttribute'));
        $this->assertTrue($validator->validate('impreso'));
    }

    public function testIncorrectInputInConstructor()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $validator = new CustomValidator('error', 'some text');
        $validator->validate('exception!');
    }

    public function testIncorrectInputInSetter()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $validator = new CustomValidator('error');
        $validator->setFunction(array(1,2,3,4));
    }

    public function testNoFunction()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $validator = new CustomValidator('error');
        $validator->validate('exception!');
    }
}
