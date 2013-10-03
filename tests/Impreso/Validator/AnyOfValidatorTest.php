<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 03.10.13
 * Time: 12:30
 */

namespace Tests\Impreso\Validator;

use Impreso\Validator\AnyOfValidator;
use Impreso\Validator\EmptyStringValidator;
use Impreso\Validator\FloatValidator;
use Impreso\Validator\IntegerValidator;
use Impreso\Validator\StringLengthValidator;


class AnyOfValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidator() {
        $value = '10.65';
        $a = new FloatValidator(); // true
        $b = new StringLengthValidator('', 0, 10); // true
        $c = new EmptyStringValidator(); // false
        $d = new IntegerValidator(); // false

        $v = new AnyOfValidator('error');
        $v->setValidators(array($a, $b, $c, $d));
        $this->assertTrue($v->validate($value));

        $v->setValidators(array($c, $a));
        $this->assertTrue($v->validate($value));

        $v->setValidators(array($a));
        $this->assertTrue($v->validate($value));

        $v->setValidators(array($c, $d));
        $this->assertFalse($v->validate($value));

        $v->setValidators(array($c));
        $this->assertFalse($v->validate($value));
    }
}
