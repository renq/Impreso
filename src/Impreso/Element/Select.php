<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 13:25
 */
namespace Impreso\Element;

use Impreso\Helper\HtmlElement;

class Select extends Element
{

    private $value = null;
    private $data = array();

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    public function __construct($name = null)
    {
        parent::__construct($name);
    }

    public function render()
    {
        $attributes = $this->getAttributes();

        $options = '';
        foreach ($this->getData() as $k => $v) {
            $optionAttributes['value'] = $k;
            if ($k === $this->getValue()) {
                $optionAttributes['selected'] = true;
            }
            $options .= (string)(new HtmlElement('option', $v, $optionAttributes));
        }

        return (string)(new HtmlElement('select', $options, $attributes));
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setValue($value)
    {
        if (!array_key_exists($value, $this->data)) {
            throw new \InvalidArgumentException("Key '$value' od select '{$this->getName()}' data doesn't exists!");
        }
        $this->value = (string)$value;
        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }
}
