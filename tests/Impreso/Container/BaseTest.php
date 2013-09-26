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
}
