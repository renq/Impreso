<?php

namespace Tests\Impreso\Element;

use Impreso\Container\Form;
use Impreso\Element\Button;
use Impreso\Element\Text;
use Impreso\Validator\RequiredField;

/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 10:33
 */
class FormTest extends \PHPUnit_Framework_TestCase
{
    public function testForm()
    {
        $form = new Form();
        $form->setMethod('post');
        $form->setAction('/');

        $name = new Text();
        $name->setLabel('Your name');
        $name->setName('name');

        $submit = new Button();
        $submit->setText('Submit form');

        $form->addElement($name);
        $form->addElement($submit);

        // asserts
        $this->assertEquals('post', $form->getMethod());
        $this->assertEquals('/', $form->getAction());

        $this->assertEquals('Your name', $name->getLabel());
        $this->assertEquals('name', $name->getName());

        $this->assertEquals('Submit form', $submit->getText());
    }

    public function testFormWithValidation()
    {
        $form = new Form();
        $form->setMethod('get');
        $form->setAction('/tests/');

        $text = new Text();
        $text->setName('name');
        $text->addValidator(new RequiredField('Required!'));
        $form->addElement($text);

        $this->assertFalse($form->validate());

        $text->set('value', 'something something dark side');
        $this->assertTrue($form->validate());
    }

    public function testMethods()
    {
        $form = new Form();
        $form->setMethod('post');
        $form->setMethod('get');
        $form->setMethod('POST');
        $form->setMethod('GET');
        $this->assertTrue(true);
    }

    public function testInvalidMethods()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $form = new Form();
        $form->setMethod('nothing');
    }

    public function testPopulate()
    {
        $form = new Form();
        $form->setMethod('post');
        $form->setAction('/');

        $name = new Text();
        $name->setLabel('Your name');
        $name->setName('name');
        $name->addValidator(new RequiredField('Required!'));

        $submit = new Button();
        $submit->setText('Submit form');

        $form->addElement($name);
        $form->addElement($submit);

        $this->assertFalse($form->validate());

        $form->populate(array(
            'name' => 'Your name'
        ));
        $this->assertTrue($form->validate());
    }

}
