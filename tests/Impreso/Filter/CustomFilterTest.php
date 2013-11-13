<?php
/**
 * Created by PhpStorm.
 * User: Michał Lipek
 * Date: 13.11.13
 * Time: 12:54
 */

namespace Tests\Impreso\Element\Filter;


use Impreso\Filter\CustomFilter;

class CustomFilterTest extends \PHPUnit_Framework_TestCase
{

    public function testFilter()
    {
        $filter = new CustomFilter(function($a) {
            return (int)$a;
        });
        $this->assertEquals(1, $filter->filter(true));
        $this->assertEquals(15, $filter->filter('15.5'));
        $this->assertNotEquals(100, $filter->filter('a100'));
    }
}
