<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 08.10.13
 * Time: 12:52
 */

namespace Tests\Impreso\Element\Filter;

use Impreso\Filter\UpperCaseFilter;

class UpperCaseFilterTest extends \PHPUnit_Framework_TestCase
{

    public function testFilter()
    {
        $filter = new UpperCaseFilter();
        $this->assertEquals('KITTY CAT', $filter->filter('Kitty Cat'));
    }
}
