<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 02.10.13
 * Time: 17:01
 */

namespace Tests\Impreso\Validator;


use Impreso\Validator\RegexValidator;

class RegexValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testStandardUsage()
    {
        $v = new RegexValidator('error');
        $v->setRegex('/^[0-1]+$/');
        $this->assertTrue($v->validate('0110101011101110'));
        $this->assertFalse($v->validate('abc'));
    }

    public function testIncorrectRegex()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $v = new RegexValidator('error', '/[+/');
        $v->validate('a');
    }
}
