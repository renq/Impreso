<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 09.10.13
 * Time: 14:20
 */

namespace Tests\Impreso\Validator;


use Impreso\Validator\CustomValidator;

class CustomValidatorTest extends \PHPUnit_Framework_TestCase
{

    public $outsideVariable;

    public function testValidator()
    {
        $validator = new CustomValidator();
        $validator->setFunction(function($v) {
            return $v;
        });

        $this->assertTrue($validator->validate(1));
        $this->assertTrue($validator->validate(true));
        $this->assertTrue($validator->validate('ok'));

        $this->outsideVariable = true;
        $self = $this;
        $validator->setFunction(function ($v) use ($self) {
            return $v && $self->outsideVariable;
        });

        $this->assertTrue($validator->validate(true));
        $this->assertFalse($validator->validate(false));

        $this->outsideVariable = false;
        $this->assertFalse($validator->validate(true));
        $this->assertFalse($validator->validate(false));
    }
}
