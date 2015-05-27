<?php
/**
 * Created by PhpStorm.
 * User: mlipek
 * Date: 27.05.15
 * Time: 16:56
 */

namespace Tests\Impreso\Validator;


use Impreso\Validator\PolishIdentityCardValidator;

class PolishIdentityCardValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidator()
    {
        $validator = new PolishIdentityCardValidator();

        $this->assertTrue($validator->validate('ADS826726'));
        $this->assertFalse($validator->validate('AA00000009'));
    }
}
