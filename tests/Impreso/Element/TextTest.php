<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 10:16
 */

namespace Tests\Impreso\Element;

use Impreso\Element\Text;
use Impreso\Filter\TrimFilter;
use Impreso\Filter\UpperCaseFilter;

class TextTest extends \PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $element = new Text();
        $element->setName('name');
        $rendered = (string)$element->render();

        $this->assertRegExp('/^<input.*type="text".*>$/', $rendered);
    }

    public function testValidation()
    {
        $element = new Text('test');
        $validator = $this->getMockForAbstractClass('\Impreso\Validator\Validator');
        $validator->expects($this->any())->method('validate')->will($this->returnValue(false));
        $element->addValidator($validator);
        $this->assertFalse($element->validate());

        $element->clearValidators();
        $validator = $this->getMockForAbstractClass('\Impreso\Validator\Validator');
        $validator->expects($this->any())->method('validate')->will($this->returnValue(true));
        $element->addValidator($validator);
        $this->assertTrue($element->validate());
    }

    public function testFilter()
    {
        $element = new Text();
        $element->addFilter(new TrimFilter());
        $element->addFilter(new UpperCaseFilter());
        $element->setValue(' Guttenberg ');
        $this->assertEquals('GUTTENBERG', $element->getValue());
    }
}
