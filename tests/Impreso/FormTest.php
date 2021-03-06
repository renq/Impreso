<?php

namespace Tests\Impreso;

use Impreso\Container\Form;
use Impreso\Element\Button;
use Impreso\Element\Checkbox;
use Impreso\Element\Hidden;
use Impreso\Element\Select;
use Impreso\Element\Text;
use Impreso\Element\TextArea;
use Impreso\Renderer\DivRenderer;
use Impreso\Validator\EmailValidator;
use Impreso\Validator\RequiredValidator;
use Impreso\Validator\StringLengthValidator;

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
        $text->addValidators(array(
                new RequiredValidator('Required!'),
                new StringLengthValidator('Too short!', 2),
            )
        );
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
        $name->addValidator(new RequiredValidator('Required!'));

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
        $content->addValidator(new RequiredValidator('This field is required'));

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


        $ids1 = new Text('ids[]');
        $form->addElement($ids1->set('value', 1));

        $ids2 = new Text('ids[]');
        $form->addElement($ids2->set('value', 2));

        $ids3 = new Text('ids[]');
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

    public function testFormAttributes()
    {
        $form = new Form();
        $form->set('class', 'my-class');

        $form->setRenderer(new DivRenderer());
        $rendered = (string)$form->render();

        $this->assertContains('class="my-class"', $rendered);
    }

    public function testPopulateFormWithCheckbox()
    {
        $form = new Form();
        $checkbox = new Checkbox('lang');
        $checkbox->set('value', 'php');
        $form->addElement($checkbox);

        $data = $form->getData();
        $this->assertEmpty($data['lang']);

        $form->populate(array('lang' => 0));
        $data = $form->getData();
        $this->assertEmpty($data['lang']);

        $form->populate(array('lang' => 1));
        $data = $form->getData();
        $this->assertEquals('php', $data['lang']);
    }

    public function testFormParameters()
    {
        $form = new Form();
        $form->set('accept-charset', 'alert()');
        $form->set('autocomplete', 'true');
        $form->set('enctype', 'multipart/form-data');
        $form->set('name', 'form-name');
        $form->set('novalidate', 'true');
        // note: incorrect attributes throws exceptions, so if we are here, evertyhing is ok
        $this->assertTrue(true);
    }

    public function testSelectFormWithEmptyValueAndValueZero()
    {
        $form = new Form();
        $select = new Select('select');
        $select->setOptions(array(
            '' => 'a',
            0 => 'b',
            1 => 'c',
        ));
        $form->addElement($select);
        $form->populate(array('select' => 0));
        $this->assertEquals('0', $select->getValue());
        $this->assertEquals(0, $select->getValue());

        $form->populate(array('select' => ''));
        $this->assertEquals('', $select->getValue());
    }

    public function testFormWithInactiveElements()
    {
        $form = new Form();
        $select = new Select('select');
        $select->setOptions(array(1 => 'c',));
        $select->setValue(1);
        $select->set('disabled', true);
        $form->addElement($select);

        $text = new Text('text');
        $text->setValue('ok');
        $form->addElement($text);

        $result = $form->getData();
        $this->assertArrayNotHasKey('select', $result);
        $this->assertArrayHasKey('text', $result);
    }

    public function testPopulateFormWithElementsWithArrayName()
    {
        $form = new Form();
        $form->addElement(new Text('name[]'));
        $form->addElement(new Text('name[]'));
        $form->addElement(new Text('name[]'));

        $form->populate(array(
            'name' => array(
                'Petyr',
                'Varys',
                'Tyrion',
            )
        ));

        $data = $form->getData();
        $this->assertArrayHasKey('name', $data);
        $this->assertCount(3, $data['name']);
    }

    public function testPopulateFormWithMultipleSelect()
    {
        $form = new Form();
        $select = new Select('name[]');
        $select->setOptions(array(
            2 => 'Bron', 10 => 'Bran', 5 => 'Brienne',
        ));
        $select->set('multiple', true);
        $form->addElement($select);

        $form->populate(array(
            'name' => array(2, 10)
        ));

        $data = $form->getData();
        $this->assertArrayHasKey('name', $data);
        $names = $data['name'];
        $this->assertContains(2, $names);
        $this->assertContains(10, $names);
        $this->assertCount(2, $names);
    }

    public function testPopulateFormWithMultipleSelectAndSomeOtherFields()
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

        $form->populate(array(
            'name' => array(2, 10),
            'age' => 15,
        ));

        $data = $form->getData();
        $this->assertArrayHasKey('name', $data);
        $names = $data['name'];
        $this->assertContains(2, $names);
        $this->assertEquals(15, $data['age']);
        $this->assertContains(10, $names);
        $this->assertCount(2, $names);
    }
}
