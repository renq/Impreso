<?php
/**
 * Created by JetBrains PhpStorm.
 * User: renq
 * Date: 16.10.13
 * Time: 21:50
 * To change this template use File | Settings | File Templates.
 */

namespace Tests\Impreso\Element;


use Impreso\Element\Radio;

class RadioTest extends \PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $element = new Radio();
        $rendered = (string)$element->render();
        $this->assertRegExp('/^<input.*type="radio".*>$/', $rendered);
    }
}
