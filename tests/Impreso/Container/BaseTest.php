<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 26.09.13
 * Time: 16:05
 */

namespace Tests\Impreso\Element\Container;


use Impreso\Container\Base;
use Impreso\Element\Text;

class BaseTest extends \PHPUnit_Framework_TestCase
{

    public function testPopulate()
    {
        /**
         * @var $base Base
         */
        $base = $this->getMockForAbstractClass('\Impreso\Container\Base');
        $base->addElement(new Text('kitty'));
        $base->addElement(new Text('cat'));
        $base->addElement(new Text('squirrel'));
        $base->addElement(new Text('pork'));

        $this->assertTrue($base->hasElement('kitty'));
        $this->assertTrue($base->hasElement('cat'));
        $this->assertTrue($base->hasElement('squirrel'));
        $this->assertTrue($base->hasElement('pork'));

        $this->assertFalse($base->hasElement('elephant'));

        $data = array(
            'kitty' => 'Loona',
            'cat' => 'Maru~',
            'squirrel' => 'The red',
        );
        $base->populate($data);

        $this->assertEquals('Loona', $base->getElement('kitty')->getValue());
        $this->assertEquals('Maru~', $base->getElement('cat')->getValue());
        $this->assertEquals('', $base->getElement('pork')->getValue());

        $base->populate(array('pork' => 'Piggy'), true);
        $this->assertEquals('Piggy', $base->getElement('pork')->getValue());

        $data['porT'] = 'Ohh...';
        $this->setExpectedException('\OutOfBoundsException');
        $base->populate($data, true);
    }

    public function testAddGetElement()
    {
        $base = $this->getMockForAbstractClass('\Impreso\Container\Base');
        $base->addElement(new Text('kitty'));
        $base->addElement(new Text('cat'));

        $this->assertTrue($base->getElement('kitty') instanceof Text);

        $this->setExpectedException('\OutOfBoundsException');
        $this->assertTrue($base->getElement('elephant'));
    }

    public function testMultipleFields()
    {
        /* @var $base Base */
        $base = $this->getMockForAbstractClass('\Impreso\Container\Base');
        $base->addElement(new Text('multipla'));
        $base->addElement(new Text('multipla'));
        $base->addElement(new Text('multipla'));

        $base->addElement(new Text('juke[1]'));
        $base->addElement(new Text('juke[2]'));

        $base->addElement(new Text('aztec[]'));
        $base->addElement(new Text('aztec[]'));
        $base->addElement(new Text('aztec[]'));
        $base->addElement(new Text('aztec[]'));

        $this->assertCount(3, $base->getElementsByName('multipla'));
        $this->assertNotCount(2, $base->getElementsByName('juke'));
        $this->assertCount(4, $base->getElementsByName('aztec[]'));

        $multiplas = $base->getElementsByName('multipla');
        $multipla1 = array_shift($multiplas);
        $multipla2 = array_shift($multiplas);

        $this->assertNotEquals($multipla1->getId(), $multipla2->getId());
    }

    public function testNoRenderer()
    {
        $this->setExpectedException('\UnexpectedValueException');
        $base = $this->getMockForAbstractClass('\Impreso\Container\Base');
        $base->render();
    }

    public function testNoRendererInToStringMethod()
    {
        $base = $this->getMockForAbstractClass('\Impreso\Container\Base');
        $base->addElement(new Text('ninja'));
        $str = (string)$base;
        $this->assertFalse(strpos($str, 'ninja'));
        $this->assertTrue(stripos($str, 'error') !== false);
    }

    public function testEmptyPopulate()
    {
        $base = $this->getMockForAbstractClass('\Impreso\Container\Base');
        $result = $base->populate(array());
        $this->assertEquals($base, $result);
    }

    public function testSetAndGetRenderer()
    {
        /* @var $renderer \Impreso\Renderer\Renderer | \PHPUnit_Framework_MockObject_MockObject */
        $renderer = $this->getMockForAbstractClass('Impreso\Renderer\Renderer');
        /* @var $base \Impreso\Container\Base | \PHPUnit_Framework_MockObject_MockObject */
        $base = $this->getMockForAbstractClass('\Impreso\Container\Base');
        $result = $base->setRenderer($renderer);

        $this->assertSame($base, $result);
        $this->assertSame($base->getRenderer(), $renderer);
    }

    public function testSetElementId()
    {
        /* @var $base \Impreso\Container\Base | \PHPUnit_Framework_MockObject_MockObject */
        $base = $this->getMockForAbstractClass('\Impreso\Container\Base');
        $element1 = new Text('text');
        $element2 = new Text('text');

        $this->assertEmpty($element1->getId());

        $base->addElement($element1);
        $this->assertEquals('text', $element1->getId());

        $base->addElement($element2);
        $this->assertEquals('text1', $element2->getId());
    }
}
