<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 10:16
 */

namespace Tests\Impreso\Element;

use Impreso\Element\Text;

class TextTest extends \PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $element = new Text();
        $element->setName('name');
        $rendered = (string)$element->render();

        $this->assertRegExp('/^<input.*type="text".*>$/', $rendered);
    }
}
