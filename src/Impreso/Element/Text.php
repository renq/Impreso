<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 13:25
 */
namespace Impreso\Element;


use Impreso\Helper\HtmlElement;

class Text extends Element
{
    public function render()
    {
        $attributes = $this->getAttributes();
        $attributes['type'] = 'text';
        return (string)(new HtmlElement('input', null, $attributes));
    }

    function setValue($value)
    {
        $this->set('value', $value);
        return $this;
    }

    function getValue()
    {
        return $this->get('value');
    }
}
