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
            return $a === true;
        });
        $this->assertTrue($filter->filter(true));
        $this->assertFalse($filter->filter('anything else'));
    }
}
