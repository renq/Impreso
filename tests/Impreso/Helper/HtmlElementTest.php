<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 15:39
 */

namespace Tests\Impreso\Helper;

use Impreso\Helper\HtmlElement;

class HtmlElementTest extends \PHPUnit_Framework_TestCase
{
    public function testSet()
    {
        $span = new HtmlElement('span', 'Span test', array('class' => 'title'));
        $this->assertRegExp('/^<span.*class="title".*>Span test<\/span>$/',  (string)$span);
    }
}
