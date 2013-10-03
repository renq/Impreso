<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 03.10.13
 * Time: 12:30
 */

namespace Tests\Impreso\Validator;


use Impreso\Validator\IntegerValidator;

class IntegerValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidator() {
        $v = new IntegerValidator();
        $this->assertTrue($v->validate(1));
        $this->assertTrue($v->validate(-1));
        $this->assertTrue($v->validate(2323));
        $this->assertTrue($v->validate("12"));
        $this->assertTrue($v->validate("+144"));
        $this->assertTrue($v->validate("-69"));

        $this->assertFalse($v->validate("+-69"));
        $this->assertFalse($v->validate("++69"));
        $this->assertFalse($v->validate("--69"));
        $this->assertFalse($v->validate("69 "));
        $this->assertFalse($v->validate(" 69"));
        $this->assertFalse($v->validate("69.69"));
        $this->assertFalse($v->validate("54,55"));
    }
}
