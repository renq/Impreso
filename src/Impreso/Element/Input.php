<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 13:25
 */
namespace Impreso\Element;

use Impreso\Helper\HtmlElement;

abstract class Input extends Element
{
    private $type;

    public function __construct($type, $name = null)
    {
        parent::__construct($name);
        $this->addValidAttributes(array('type'));
        $this->set('type', $type);
        $this->type = $type;
    }

    public function render()
    {
        $attributes = $this->getAttributes();
        $attributes['type'] = $this->type;
        return (string)(new HtmlElement('input', null, $attributes));
    }

    public function setValue($value)
    {
        $this->set('value', $value);
        return $this;
    }

    public function getValue()
    {
        return $this->get('value');
    }
}
