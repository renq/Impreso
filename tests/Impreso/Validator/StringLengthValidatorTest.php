<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 02.10.13
 * Time: 15:56
 */

namespace Tests\Impreso\Validator;


use Impreso\Validator\StringLengthValidator;

class StringLengthValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testMaxMin()
    {
        $v = new StringLengthValidator('error', 2, 4);
        $this->assertTrue($v->validate('ab'));
        $this->assertTrue($v->validate('abc'));
        $this->assertTrue($v->validate('abcd'));
        $this->assertTrue($v->validate(123));
        $this->assertFalse($v->validate('a'));
        $this->assertFalse($v->validate('abcde'));
        $this->assertFalse($v->validate(null));
        $this->assertFalse($v->validate(true));
        $this->assertFalse($v->validate(false));
    }

    public function testOnlyMin()
    {
        $v = new StringLengthValidator('error', 3);
        $this->assertTrue($v->validate('abc'));
        $this->assertTrue($v->validate('abcd'));
        $this->assertFalse($v->validate('ab'));
        $this->assertFalse($v->validate(''));
    }

    public function testOnlyMax()
    {
        $v = new StringLengthValidator('error', null, 3);
        $this->assertTrue($v->validate('abc'));
        $this->assertTrue($v->validate('ab'));
        $this->assertTrue($v->validate(''));
        $this->assertFalse($v->validate('abcd'));
    }

    public function testMinEqualsToMax()
    {
        $v1 = new StringLengthValidator('error', 2, 2);
        $this->assertTrue($v1->validate('ab'));

        $v2 = new StringLengthValidator('error', 0, 0);
        $this->assertTrue($v2->validate(''));
    }

    public function testThrowingException()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $v = new StringLengthValidator('error');
        $v->setMinLength('23');
    }
}
