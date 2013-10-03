<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 03.10.13
 * Time: 11:10
 */

namespace Tests\Impreso\Validator;


use Impreso\Validator\NotEqualValidator;

class NotEqualValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidator()
    {
        $v = new NotEqualValidator('error', 0);
        $this->assertTrue($v->validate(1));
        $this->assertTrue($v->validate(true));
        $this->assertFalse($v->validate(0));
        $this->assertFalse($v->validate(null));
        $this->assertFalse($v->validate(false));

        $v->setNotEqual('abc');
        $this->assertTrue($v->validate('ab'));
        $this->assertFalse($v->validate('abc'));
    }
}
