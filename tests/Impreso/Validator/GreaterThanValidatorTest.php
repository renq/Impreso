<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 03.10.13
 * Time: 10:25
 */

namespace Tests\Impreso\Validator;

use Impreso\Validator\GreaterThanValidator;

class GreaterThanValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidator()
    {
        $v = new GreaterThanValidator('error', 15);
        $this->assertFalse($v->validate(14.99));
        $this->assertFalse($v->validate(5));
        $this->assertFalse($v->validate(-5));
        $this->assertFalse($v->validate(-15));
        $this->assertFalse($v->validate(-99999.99));

        $this->assertFalse($v->validate(15));
        $this->assertTrue($v->validate(15.001));
        $this->assertTrue($v->validate(100));

        $v->setGreaterThan(0);
        $this->assertFalse($v->validate(-1));
        $this->assertTrue($v->validate(1));
    }

    public function testIncorrectComparator()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $v = new GreaterThanValidator();
        $v->setGreaterThan('abc');
    }

    public function testNoComparator()
    {
        $this->setExpectedException('\UnexpectedValueException');
        $v = new GreaterThanValidator();
        $v->validate(0);
    }
}
