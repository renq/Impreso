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

    public function testSelect()
    {
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

    public function testSetValue()
    {
        $element = new Select();
        $element->setOptions(array(
            '' => 'a',
            0 => 'b',
            1 => 'c',
        ));
        $element->setValue('0');
        $this->assertEquals(0, $element->getValue());
        $element->setValue('');
        $this->assertEquals('', $element->getValue());
    }

    public function testMutliple()
    {
        $element = new Select();
        $element->set('multiple', true);
        $this->assertContains(' multiple', $element->render());

        $element->setOptions(array(
            'bran' => 'Bran',
            'bron' => 'Bron',
            'brienne' => 'Brienne',
        ));
        $element->setValue(array(
            'bran', 'brienne',
        ));
        $values = $element->getValue();
        $this->assertCount(2, $values);
        $this->assertContains('bran', $values);
        $this->assertContains('brienne', $values);
    }

    public function testMutlipleWithOptgroups()
    {
        $element = new Select();
        $element->set('multiple', true);
        $this->assertContains(' multiple', $element->render());

        $element->setOptions(array(
            'starks' => array(
                'bran' => 'Bran',
                'arya' => 'Arya',
                'sansa' => 'Sansa',
            ),
            'lanisters' => array(
                'cersei' => 'Cersei',
                'joffrey' => 'Joffrey',
            ),
            'targaryen' => array(
                'daenerys' => 'Queen of the Andals and the Rhoynar and the First Men, Lord of the Seven Kingdoms. Khaleesi of the Great Grass Sea',
                'viserys' => 'Viserys',
            )
        ));
        $element->setValue(array(
            'sansa', 'cersei', 'daenerys',
        ));
        $values = $element->getValue();
        $this->assertCount(3, $values);
        $this->assertContains('daenerys', $values);
        $this->assertContains('cersei', $values);
        $this->assertContains('sansa', $values);

        $html = $element->render();
        $this->assertEquals(3, substr_count($html, 'selected'));
    }
}
