<?php
/**
 * Created by PhpStorm.
 * User: Michał Lipek
 * Date: 26.03.14
 * Time: 12:57
 */

namespace Tests\Impreso\Element\Filter;


use Impreso\Filter\IntegerFilter;

class IntegerFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testFilter()
    {
        $f = new IntegerFilter();
        $this->assertEquals(1, $f->filter(1));
        $this->assertEquals(66, $f->filter(66.6));
        $this->assertEquals(55, $f->filter("55"));
        $this->assertEquals(55, $f->filter("55 or less"));
        $this->assertEquals(-50, $f->filter("-50"));
        $this->assertEquals(0, $f->filter(""));
        $this->assertEquals(0, $f->filter("not an number"));

        $this->assertNotEquals(10, $f->filter("ten"));
        $this->assertNotEquals(10, $f->filter("a10"));
    }
}
