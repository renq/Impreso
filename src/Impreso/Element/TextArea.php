<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 13:25
 */
namespace Impreso\Element;


use Impreso\Helper\HtmlElement;

class TextArea extends Element
{
    private $value;

    public function render()
    {
        $attributes = $this->getAttributes();
        return (string)(new HtmlElement('textarea', $this->getValue(), $attributes));
    }

    function setValue($value)
    {
        $this->value = $value;
    }

    function getValue()
    {
        return $this->value;
    }
}
