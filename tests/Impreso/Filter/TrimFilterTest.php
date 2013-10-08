<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 08.10.13
 * Time: 12:52
 */

namespace Tests\Impreso\Element\Filter;


use Impreso\Filter\TrimFilter;

class TrimFilterTest extends \PHPUnit_Framework_TestCase
{

    public function testFilter()
    {
        $filter = new TrimFilter();
        $this->assertEquals('abc', $filter->filter(' abc  '));
    }
}
