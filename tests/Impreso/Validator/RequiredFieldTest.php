<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 15:39
 */

namespace Tests\Impreso\Validator;

use Impreso\Element\Text;
use Impreso\Validator\RequiredFieldValidator;

class RequiredFieldValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testValidator()
    {
        $input = new Text();
        $input->addValidator(new RequiredFieldValidator('Error'));
        $this->assertFalse($input->validate());

        $input->setValue("Shoul'd be ok");
        $this->assertTrue($input->validate());
    }
}
