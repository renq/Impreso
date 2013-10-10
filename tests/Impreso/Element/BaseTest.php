<?php
/**
 * Created by JetBrains PhpStorm.
 * User: renq
 * Date: 10.10.13
 * Time: 22:32
 * To change this template use File | Settings | File Templates.
 */

namespace Tests\Impreso\Element;


class BaseTest extends \PHPUnit_Framework_TestCase
{
    public function testValidAttributes()
    {
        /* @var $base \Impreso\Element\Base */
        $base = $this->getMockForAbstractClass('\Impreso\Element\Base');
        $base->setValidAttributes(array());
        $this->assertEquals(array(), $base->getValidAttributes());

        $base->addValidAttributes(array('type', 'id'));
        $this->assertContains('type', $base->getValidAttributes());
        $this->assertContains('id', $base->getValidAttributes());
        $this->assertEquals(2, count($base->getValidAttributes()));

        $this->assertFalse($base->isValidAttribute('class'));
        $this->assertTrue($base->isValidAttribute('id'));
    }

    public function testSetGetAttributes()
    {
        /* @var $base \Impreso\Element\Base */
        $base = $this->getMockForAbstractClass('\Impreso\Element\Base');
        $base->setValidAttributes(array('id', 'class'));
        $base->set('id', 'my-id');
        $base->set('class', 'my-class');
        $base->set('data-something', 'something');
        $this->assertEquals('my-id', $base->get('id'));
        $this->assertEquals('my-class', $base->get('class'));
        $this->assertEquals('something', $base->get('data-something'));
    }

    public function testIncorrectAttribute()
    {
        /* @var $base \Impreso\Element\Base */
        $base = $this->getMockForAbstractClass('\Impreso\Element\Base');
        $this->setExpectedException('\InvalidArgumentException');
        $base->set('ugly-attr', 'wrong');
    }
}
