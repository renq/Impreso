<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 03.10.13
 * Time: 11:10
 */

namespace Tests\Impreso\Validator;

use Impreso\Validator\EqualValidator;

class EqualValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidator()
    {
        $v = new EqualValidator('error', 0);
        $this->assertFalse($v->validate(1));
        $this->assertFalse($v->validate(true));
        $this->assertTrue($v->validate(0));
        $this->assertTrue($v->validate(null));
        $this->assertTrue($v->validate(false));

        $v->setEqual('abc');
        $this->assertFalse($v->validate('ab'));
        $this->assertTrue($v->validate('abc'));
    }
}
