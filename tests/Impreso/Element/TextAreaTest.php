<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 10:16
 */

namespace Tests\Impreso\Element;

use Impreso\Element\TextArea;
use Impreso\Filter\TrimFilter;
use Impreso\Filter\UpperCaseFilter;

class TextAreaTest extends \PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $element = new TextArea();
        $element->setName('qwerty');
        $element->set('value', 'abcd');
        $this->assertRegExp('/^<textarea.*value="abcd".*><\/textarea>$/', (string)$element);
        $this->assertRegExp('/^<textarea.*name="qwerty".*><\/textarea>$/', (string)$element);

        $element->setValue('xyz');
        $this->assertRegExp('/^<textarea.*value="abcd".*>xyz<\/textarea>$/', (string)$element);
    }

    public function testFilter()
    {
        $element = new TextArea();
        $element->addFilter(new TrimFilter())->addFilter(new UpperCaseFilter());
        $element->setValue('  Python ');
        $this->assertEquals('PYTHON', $element->getValue());
    }


    public function testFluentInterface()
    {
        $element = new TextArea('test');
        $this->assertEquals($element, $element->setValue('test'));
    }
}
