<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 10:21
 */

namespace Impreso\Element;

abstract class Base
{

    private $validAttributes = array();
    private $attributes = array();
    private $name;

    public function __construct()
    {
        $this->setValidAttributes(array(
            'id', 'class', 'title', 'style', 'dir', 'lang', 'xml:lang',
            'onclick', 'ondblclick', 'onmousedown', 'onmouseup', 'onmouseover', 'onmousemove',
            'onmouseout', 'onkeypress', 'onkeydown', 'onkeyup'
        ));
    }

    public function setValidAttributes(array $list)
    {
        if (is_array($list)) {
            $this->validAttributes = $list;
            return true;
        }
        return false;
    }

    public function addValidAttributes(array $list)
    {
        $this->validAttributes = array_merge($this->validAttributes, $list);
    }

    public function getValidAttributes()
    {
        return $this->validAttributes;
    }

    public function isValidAttribute($attribute)
    {
        return in_array($attribute, $this->validAttributes);
    }

    public function set($attribute, $value)
    {
        if (in_array($attribute, $this->validAttributes) || strpos($attribute, 'data-') === 0) {
            $this->attributes[$attribute] = $value;
            return $this;
        }
        else {
            throw new \InvalidArgumentException("{$attribute} is not valid attribute.");
        }
    }

    public function get($attribute)
    {
        if (array_key_exists($attribute, $this->attributes)) {
            return $this->attributes[$attribute];
        }
        return '';
    }

    public function getAttributes() {
        return $this->attributes;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        $this->set('name', $name);
    }

    public function __toString()
    {
        return $this->render();
    }
}
