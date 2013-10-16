<?php
/**
 * Created by JetBrains PhpStorm.
 * User: renq
 * Date: 16.10.13
 * Time: 21:50
 * To change this template use File | Settings | File Templates.
 */

namespace Tests\Impreso\Element;


use Impreso\Element\Submit;

class SubmitTest extends \PHPUnit_Framework_TestCase
{

    public function testRender()
    {
        $element = new Submit();
        $rendered = (string)$element->render();
        $this->assertRegExp('/^<input.*type="submit".*>$/', $rendered);
    }
}
