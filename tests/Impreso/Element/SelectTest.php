<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 03.10.13
 * Time: 16:27
 */

namespace Tests\Impreso\Element;


use Impreso\Element\Select;

class SelectTest extends \PHPUnit_Framework_TestCase
{

    public function testSelect() {
        $select = new Select('test');
        $select->setData(array(
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
}
