<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 09.10.13
 * Time: 13:33
 */

namespace Tests\Impreso\Validator;


use Impreso\Validator\PasswordCharactersValidator;

class PasswordCharactersValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidator()
    {
        $validator = new PasswordCharactersValidator('error', 1, 1, 1, 1);
        $this->assertTrue($validator->validate('aA1!'));
        $this->assertTrue($validator->validate('aaBB20^'));
        $this->assertFalse($validator->validate('xY0'));
        $this->assertFalse($validator->validate('xY!'));
        $this->assertFalse($validator->validate('xx0!'));
        $this->assertFalse($validator->validate('XX0='));

        $validator->setNumberOfBigLetters(3)
            ->setNumberOfDigits(3)
            ->setNumberOfSmallLetters(3)
            ->setNumberOfSpecialChars(3);

        $this->assertTrue($validator->validate('abcDEF0123[=]'));
        $this->assertFalse($validator->validate('abcDEF0123[]'));
    }
}
