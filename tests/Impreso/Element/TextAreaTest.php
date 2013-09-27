<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 10:16
 */

namespace Tests\Impreso\Element;

use Impreso\Element\TextArea;

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
}
