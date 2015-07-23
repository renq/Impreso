<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 10:16
 */

namespace Tests\Impreso\Element;

use Impreso\Element\Checkbox;
use Impreso\Filter\IntegerFilter;

class CheckboxTest extends \PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $element = new Checkbox();
        $element->setName('qwerty');
        $element->set('value', 'asdf');
        $this->assertRegExp('/^<input.*type="checkbox".*>$/', (string)$element);
        $this->assertRegExp('/^<input.*value="asdf".*>$/', (string)$element);
        $element->set('checked', true);
        $this->assertRegExp('/^<input.* checked.*>$/', (string)$element);
        $element->set('checked', false);
        $this->assertTrue(strpos((string)$element, ' checked') === false);
    }

    public function testSetData()
    {
        $element = new Checkbox('asdf');
        $element->set('value', 15);
        $this->assertFalse($element->isChecked());
        $element->setValue(false);
        $this->assertFalse($element->isChecked());
        $this->assertNotContains('checked', $element->render());
        $this->assertNotContains('value="15"', $element->render());

        $element->setValue(true);
        $this->assertTrue($element->isChecked());
        $this->assertContains('checked', $element->render());
    }

    public function testFilter()
    {
        $element = new Checkbox();
        $element->setValue('15x');
        $element->addFilter(new IntegerFilter());
        $this->assertEquals(15, $element->getValue());

        $element->setValue(false);
        $this->assertEquals("0", $element->getValue());
    }

    public function testFluentInterface()
    {
        $element = new Checkbox('test');
        $this->assertEquals($element, $element->setValue(1));
    }
}
