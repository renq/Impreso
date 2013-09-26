<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 14:30
 */

namespace Impreso\Container;

use \Impreso\Element\Element;

class Base
{
    private $elements = array();

    public function addElement(Element $element)
    {
        $element->set('id', $element->getName());
        $this->elements[$element->getName()] = $element;
    }

    public function getElements()
    {
        return $this->elements;
    }

    public function populate(array $data, $strict = false)
    {
        foreach ($data as $key => $value) {
            if (!$this->hasElement($key)) {
                if ($strict) {
                    throw new \OutOfBoundsException("Element '$key' doesn't exists in form.");
                }
                continue;
            }
            $this->getElement($key)->setValue($value);
        }
    }

    public function hasElement($key)
    {
        return (isset($this->elements[$key]));
    }

    public function getElement($key)
    {
        if (!$this->hasElement($key)) {
            throw new \OutOfBoundsException("Element '$key' doesn't exists.");
        }
        return $this->elements[$key];
    }
}
