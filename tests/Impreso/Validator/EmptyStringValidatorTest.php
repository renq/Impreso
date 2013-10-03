<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 03.10.13
 * Time: 11:36
 */

namespace Tests\Impreso\Validator;


use Impreso\Validator\EmptyStringValidator;

class EmptyStringValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidate() {
        $v = new EmptyStringValidator('error');
        $this->assertTrue($v->validate(''));
        $this->assertFalse($v->validate('0'));
        $this->assertFalse($v->validate(" "));
        $this->assertFalse($v->validate(1));
        $this->assertFalse($v->validate(false));
        $this->assertFalse($v->validate(null));
    }
}
