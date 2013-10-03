<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 03.10.13
 * Time: 10:25
 */

namespace Tests\Impreso\Validator;

use Impreso\Validator\LessThanValidator;

class LessThanValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidator()
    {
        $v = new LessThanValidator('error', 15);
        $this->assertTrue($v->validate(14.99));
        $this->assertTrue($v->validate(5));
        $this->assertTrue($v->validate(-5));
        $this->assertTrue($v->validate(-15));
        $this->assertTrue($v->validate(-99999.99));

        $this->assertFalse($v->validate(15));
        $this->assertFalse($v->validate(15.001));
        $this->assertFalse($v->validate(100));

        $v->setLessThan(0);
        $this->assertTrue($v->validate(-1));
        $this->assertFalse($v->validate(1));
    }
}
