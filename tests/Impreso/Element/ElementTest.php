<?php
/**
 * Created by JetBrains PhpStorm.
 * User: renq
 * Date: 10.10.13
 * Time: 22:56
 * To change this template use File | Settings | File Templates.
 */

namespace Tests\Impreso\Element;


class ElementTest extends \PHPUnit_Framework_TestCase
{
    public function testValidators()
    {
        /* @var $element \Impreso\Element\Element */
        $element = $this->getMockForAbstractClass('\Impreso\Element\Element');

        $v1 = $this->getMockForAbstractClass('\Impreso\Validator\Validator');
        $v2 = $this->getMockForAbstractClass('\Impreso\Validator\Validator');
        $v3 = $this->getMockForAbstractClass('\Impreso\Validator\Validator');
        $v4 = $this->getMockForAbstractClass('\Impreso\Validator\Validator');

        $element->addValidators(array($v1, $v2));
        $this->assertTrue(in_array($v1, $element->getValidators(), true));
        $this->assertTrue(in_array($v2, $element->getValidators(), true));
        $this->assertFalse(in_array($v3, $element->getValidators(), true));

        $element->clearValidators();
        $this->assertTrue(0 === count($element->getValidators()));

        $element->addValidator($v4);
        $this->assertEquals(array($v4), $element->getValidators());
    }

    public function testFilters()
    {
        /* @var $element \Impreso\Element\Element */
        $element = $this->getMockForAbstractClass('\Impreso\Element\Element');

        $f1 = $this->getMockForAbstractClass('\Impreso\Filter\Filter');
        $f2 = $this->getMockForAbstractClass('\Impreso\Filter\Filter');
        $f3 = $this->getMockForAbstractClass('\Impreso\Filter\Filter');
        $f4 = $this->getMockForAbstractClass('\Impreso\Filter\Filter');

        $element->addFilters(array($f1, $f2));
        $this->assertTrue(in_array($f1, $element->getFilters(), true));
        $this->assertTrue(in_array($f2, $element->getFilters(), true));
        $this->assertFalse(in_array($f3, $element->getFilters(), true));

        $element->clearFilters();
        $this->assertTrue(0 === count($element->getFilters()));

        $element->addFilter($f4);
        $this->assertEquals(array($f4), $element->getFilters());
    }
}
