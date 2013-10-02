<?php

namespace Tests\Impreso\Element;

use Impreso\Container\Form;
use Impreso\Element\Button;
use Impreso\Element\Text;
use Impreso\Element\TextArea;
use Impreso\Validator\EmailValidator as EmailValidator;
use Impreso\Validator\RequiredFieldValidator as RequiredFieldValidator;

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
        $text->addValidator(new RequiredFieldValidator('Required!'));
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
        $name->addValidator(new RequiredFieldValidator('Required!'));

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

    public function testStandardUsage()
    {
        $form = new Form();
        $form->setMethod('post');
        $form->setAction('/');

        $name = new Text();
        $name->setLabel('E-mail');
        $name->setName('email');
        $name->addValidator(new EmailValidator('Enter valid email!'));

        $content = new TextArea();
        $content->setLabel('Message');
        $content->setName('content');
        $content->addValidator(new RequiredFieldValidator('This field is required'));

        $form
            ->addElement($name)
            ->addElement($content);

        $this->assertFalse($form->validate());

        $post = array(
            'email' => 'michal@lipek.net',
            'content' => 'Test message',
        );
        $form->populate($post);
        $this->assertTrue($form->validate());
    }
}
