<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 09.10.13
 * Time: 13:05
 */

namespace Tests\Impreso\Container;


use Impreso\Container\Form;
use Impreso\Element\Hidden;
use Impreso\Element\Password;
use Impreso\Element\Select;
use Impreso\Element\Text;
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

    public function testGetElementsByName()
    {
        $form = new Form();
        $select = new Select('name[]');
        $select->setOptions(array(
            2 => 'Bron', 10 => 'Bran', 5 => 'Brienne',
        ));
        $select->set('multiple', true);
        $form->addElement($select);

        $input = new Text('age');
        $form->addElement($input);

        //$this->assertEquals(array($select), $form->getElementsByName('name'));
        $this->assertEquals(array($select), $form->getElementsByName('name[]'));
        $this->assertEquals(array($input), $form->getElementsByName('age'));
    }

    public function testGetAllErrors()
    {
        $expectedResult = array(
            'errors' => array(
                'errorForm'
            ),
            'children' => array(
                'foo' => array(
                    'errorFoo1',
                    'errorFoo2',
                ),
                'bar' => array(
                    'errorBar'
                ),
            ),
        );

        $form = new Form();
        $form->addError($expectedResult['errors'][0]);

        $foo = new Hidden('foo');
        $foo->addError($expectedResult['children']['foo'][0]);
        $foo->addError($expectedResult['children']['foo'][1]);
        $form->addElement($foo);

        $bar = new Hidden('bar');
        $bar->addError($expectedResult['children']['bar'][0]);
        $form->addElement($bar);

        $this->assertEquals($expectedResult, $form->getAllErrors());
    }
}
