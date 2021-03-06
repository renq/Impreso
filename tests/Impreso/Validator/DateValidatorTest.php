<?php
/**
 * Created by PhpStorm.
 * User: renq
 * Date: 22.01.14
 * Time: 12:55
 */

namespace Tests\Impreso\Validator;


use Impreso\Validator\DateValidator;

class DateValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidator()
    {
        $v = new DateValidator();

        $this->assertTrue($v->validate("April 5th 1983"));
        $this->assertTrue($v->validate("2014-01-22"));
        $this->assertTrue($v->validate("01/22/2014"));
        $this->assertTrue($v->validate("2014-01-22T00:00:01"));
        $this->assertTrue($v->validate("2014-01-22 12:30:10"));

        $this->assertFalse($v->validate("2014/30/02"));
        $this->assertFalse($v->validate("2014-13-01"));
        $this->assertFalse($v->validate("2014-02-29"));

        $this->assertFalse($v->validate("0000-00-00"));
        $this->assertFalse($v->validate("0000-00-00 00:00:00"));
    }
}
 