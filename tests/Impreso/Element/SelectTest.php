<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 03.10.13
 * Time: 16:27
 */

namespace Tests\Impreso\Element;


use Impreso\Element\Select;
use Impreso\Filter\TrimFilter;
use Impreso\Filter\UpperCaseFilter;

class SelectTest extends \PHPUnit_Framework_TestCase
{

    public function testSelect() {
        $select = new Select('test');
        $select->setOptions(array(
            'abc' => '-- select --',
            'qwe' => 'Cat',
            'zxc' => 'Dog',
        ));
        $this->assertNotContains('selected', $select->render());
        $this->assertContains('<option value="qwe">', $select->render());
        $this->assertContains('>Cat</option>', $select->render());

        $this->assertNull($select->getValue());

        $select->setValue('qwe');
        $this->assertEquals('qwe', $select->getValue());

        $this->assertContains('selected', $select->render());

        $this->setExpectedException('\InvalidArgumentException');
        $select->setValue('breaking bad');
    }

    public function testSelectWithOptgroups()
    {
        $select = new Select('test');
        $select->setOptions(array(
            'Animals' => array(
                'cat' => 'Cat',
                'dog' => 'Dog',
                'monkey' => 'Monkey',
                'rat' => 'Rat',
            ),
            'Plants' => array(
                'lime' => 'Lime',
                'tomato' => 'Tomato',
                'oak' => 'Oak',
            ),
        ));

        $this->assertContains('<optgroup label="Animals">', $select->render());
        $this->assertContains('<optgroup label="Plants">', $select->render());
        $this->assertContains('value="cat"', $select->render());
        $this->assertContains('>Cat</option>', $select->render());

        $select->setValue('cat');
        $this->assertContains('selected', $select->render());

        $this->setExpectedException('\InvalidArgumentException');
        $select->setValue('breaking bad');
    }

    public function testFilter()
    {
        $element = new Select();
        $element->addFilter(new TrimFilter())->addFilter(new UpperCaseFilter());
        $element->setOptions(array(
            ' Python' => ' The Best Language ',
            ' Perl   ' => ' Omg :) ',
        ));
        $element->setValue(' Python');
        $this->assertEquals('PYTHON', $element->getValue());
    }
}
