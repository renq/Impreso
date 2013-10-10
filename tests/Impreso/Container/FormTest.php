<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 09.10.13
 * Time: 13:05
 */

namespace Tests\Impreso\Container;


use Impreso\Container\Form;
use Impreso\Element\Password;
use Impreso\Validator\CustomValidator;
use Impreso\Validator\PasswordCharactersValidator;

class FormTest extends \PHPUnit_Framework_TestCase
{

    public function testPassword()
    {
        $form = new Form();
        $password = new Password('password');
        $password->addValidator(new PasswordCharactersValidator('password too simple error'));
        $password2 = new Password('repeat');
        $password2->addValidator(new CustomValidator(
            'repeat error',
            function($value) use ($password) {
                return $password->getValue() == $value;
            }
        ));

        $form->addElement($password)
            ->addElement($password2);

        $form->populate(array(
            'password' => 'ABCdef0123!@#',
            'repeat' => 'different password',
        ));
        $form->populate(array('repeat' => 'ABCdef0123!@#'));
        $this->assertTrue($form->validate());
    }

    public function testErrors()
    {
        $form = new Form();
        $form->addError('abc');
        $form->addError('xyz');
        $this->assertEquals(array('abc', 'xyz'), $form->getErrors());
    }
}
