<?php

namespace Tests\Impreso;

use Impreso\Container\Form;
use Impreso\Element\Button;
use Impreso\Element\Checkbox;
use Impreso\Element\Hidden;
use Impreso\Element\Text;
use Impreso\Element\TextArea;
use Impreso\Renderer\DivRenderer;
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
            'breaking' => 'bad',
        );
        $form->populate($post);
        $this->assertTrue($form->validate());

        $data = $form->getData();
        $this->assertEquals(2, count($data));
        $this->assertArrayHasKey('email', $data);
        $this->assertArrayHasKey('content', $data);
        $this->assertArrayNotHasKey('breaking', $data);
    }

    public function testMoreComplicatedUsage()
    {
        $form = new Form();
        $form->addElement(new Hidden('csrf'));
        $form->addElement(new Text('name'));

        $a = new Text('list[a]');
        $form->addElement($a->set('value', 'a'));

        $b = new Text('list[b]');
        $form->addElement($b->set('value', 'b'));

        $c = new Text('list[c]');
        $form->addElement($c->set('value', 'c'));


        $ids1 = new Checkbox('ids[]');
        $form->addElement($ids1->set('value', 1));

        $ids2 = new Checkbox('ids[]');
        $form->addElement($ids2->set('value', 2));

        $ids3 = new Checkbox('ids[]');
        $form->addElement($ids3->set('value', 3));

        $form->setRenderer(new DivRenderer());

        $html = (string)$form;

        $this->assertTrue(substr_count($html, 'name="list[') == 3);
        $this->assertTrue(substr_count($html, 'name="ids[]"') == 3);

        $data = $form->getData();
        // list
        $this->assertTrue(is_array($data['list']));
        $this->assertArrayHasKey('a', $data['list']);
        $this->assertArrayHasKey('b', $data['list']);
        $this->assertArrayHasKey('c', $data['list']);
        $this->assertCount(3, $data['list']);

        $this->assertEquals('a', $data['list']['a']);
        $this->assertEquals('b', $data['list']['b']);
        $this->assertEquals('c', $data['list']['c']);

        // ids
        $this->assertTrue(is_array($data['ids']));
        $this->assertArrayHasKey(0, $data['ids']);
        $this->assertArrayHasKey(1, $data['ids']);
        $this->assertArrayHasKey(2, $data['ids']);
        $this->assertCount(3, $data['ids']);
        $this->assertEquals($data['ids'], array(0 => 1, 1 => 2, 2 => 3));

        $newData = array(
            'csrf' => 'omg hi',
            'name' => 'doge',
            'list' => array(
                'a' => 'wow',
                'b' => 'cool',
                'c' => 'so hip',
            ),
            'ids' => array(11, 12, 13, 14), // 4 elements, instead of 3
        );
        $form->populate($newData);

        // list
        $data = $form->getData();

        $this->assertEquals('omg hi', $data['csrf']);
        $this->assertTrue(is_array($data['list']));
        $this->assertArrayHasKey('a', $data['list']);
        $this->assertArrayHasKey('b', $data['list']);
        $this->assertArrayHasKey('c', $data['list']);
        $this->assertCount(3, $data['list']);

        $this->assertEquals('wow', $data['list']['a']);
        $this->assertEquals('cool', $data['list']['b']);
        $this->assertEquals('so hip', $data['list']['c']);

        // ids
        $this->assertTrue(is_array($data['ids']));
        $this->assertArrayHasKey(0, $data['ids']);
        $this->assertArrayHasKey(1, $data['ids']);
        $this->assertArrayHasKey(2, $data['ids']);
        $this->assertCount(3, $data['ids']);
        $this->assertEquals($data['ids'], array(0 => 11, 1 => 12, 2 => 13));
    }
}
