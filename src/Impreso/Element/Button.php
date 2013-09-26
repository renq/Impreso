<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 13:25
 */

namespace Impreso\Element;


use Impreso\Helper\HtmlElement;

class Button extends Element
{

    private $text;

    /**
     * @param mixed $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    function render()
    {
        return (string)(new HtmlElement('button', $this->getText(), $this->getAttributes()));
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
