<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 03.10.13
 * Time: 12:30
 */

namespace Tests\Impreso\Validator;

use Impreso\Validator\AllOfValidator;
use Impreso\Validator\EmptyStringValidator;
use Impreso\Validator\FloatValidator;
use Impreso\Validator\IntegerValidator;
use Impreso\Validator\StringLengthValidator;


class AllOfValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidator() {
        $value = '10.65';
        $a = new FloatValidator(); // true
        $b = new StringLengthValidator('', 0, 10); // true
        $c = new EmptyStringValidator(); // false
        $d = new IntegerValidator(); // false

        $v = new AllOfValidator('error');
        $v->setValidators(array($a, $b, $c, $d));
        $this->assertFalse($v->validate($value));

        $v->setValidators(array($a, $c));
        $this->assertFalse($v->validate($value));

        $v->setValidators(array($c, $d));
        $this->assertFalse($v->validate($value));

        $v->setValidators(array($c));
        $this->assertFalse($v->validate($value));

        $v->setValidators(array($a, $b));
        $this->assertTrue($v->validate($value));

        $v->setValidators(array($a));
        $this->assertTrue($v->validate($value));
    }

    public function testIncorrectInputInConstructor()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $a = new FloatValidator();
        $b = new \ArrayObject(array(1,2,3));

        $v = new AllOfValidator('error', array($a, $b));
    }

    public function testIncorrectInputInSetter()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $a = new FloatValidator();
        $b = new \ArrayObject(array(1,2,3));

        $v = new AllOfValidator('error');
        $v->setValidators(array($a, $b));
    }
}
