<?php
/**
 * Created by PhpStorm.
 * User: Michał Lipek
 * Date: 09.10.14
 * Time: 17:27
 */

namespace Tests\Impreso\Element;


class InputTest extends \PHPUnit_Framework_TestCase
{

    public function testFluentInterface()
    {
        $element = $this->getMockForAbstractClass('\Impreso\Element\Input', array('test'));
        $this->assertEquals($element, $element->setValue('test'));
    }
}
