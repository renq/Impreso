<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 10:16
 */

namespace Tests\Impreso\Element;

use Impreso\Element\Button;
use Impreso\Filter\TrimFilter;
use Impreso\Filter\UpperCaseFilter;

class ButtonTest extends \PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $element = new Button();
        $element->setText('button text');
        $rendered = (string)$element->render();

        $this->assertRegExp('/^<button.*>button text<\/button>$/', $rendered);
    }

    public function testFilter()
    {
        $element = new Button();
        $element->addFilter(new TrimFilter())->addFilter(new UpperCaseFilter());
        $element->setValue(' Click   this BUTTON!');
        $this->assertEquals('CLICK   THIS BUTTON!', $element->getValue());
    }

    public function testFluentInterface()
    {
        $element = new Button('test');
        $this->assertEquals($element, $element->setValue('test'));
    }
}
