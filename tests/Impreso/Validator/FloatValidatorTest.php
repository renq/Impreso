<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 03.10.13
 * Time: 12:30
 */

namespace Tests\Impreso\Validator;


use Impreso\Validator\FloatValidator;

class FloatValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidator() {
        $v = new FloatValidator();
        $this->assertTrue($v->validate(1));
        $this->assertTrue($v->validate(-1));
        $this->assertTrue($v->validate(2323));
        $this->assertTrue($v->validate(2323.121212));
        $this->assertTrue($v->validate(-11.99));
        $this->assertTrue($v->validate("69.69"));
        $this->assertTrue($v->validate("12"));
        $this->assertTrue($v->validate("+144.23"));
        $this->assertTrue($v->validate("-69.99"));

        $this->assertFalse($v->validate("+-10"));
        $this->assertFalse($v->validate("++70"));
        $this->assertFalse($v->validate("--50"));
        $this->assertFalse($v->validate("69 "));
        $this->assertFalse($v->validate(" 69"));
        $this->assertFalse($v->validate("54,55"));
        $this->assertFalse($v->validate("54,55"));
    }
}
