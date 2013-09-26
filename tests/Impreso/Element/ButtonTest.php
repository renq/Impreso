<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 10:16
 */

namespace Tests\Impreso\Element;

use Impreso\Element\Button;

class ButtonTest extends \PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $element = new Button();
        $element->setText('button text');
        $rendered = (string)$element->render();

        $this->assertRegExp('/^<button.*>button text<\/button>$/', $rendered);
    }
}
