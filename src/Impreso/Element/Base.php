<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 10:21
 */

namespace Impreso\Element;

abstract class Base implements Renderable
{

    private $validAttributes = array();
    private $attributes = array();
    private $name;
    private $id;

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
        $this->validAttributes = $list;
        return $this;
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

    /**
     * @param $attribute
     * @param $value
     * @return \Impreso\Element\Base
     * @throws \InvalidArgumentException
     */
    public function set($attribute, $value)
    {
        if (in_array($attribute, $this->validAttributes) || strpos($attribute, 'data-') === 0) {
            $this->attributes[$attribute] = $value;
            return $this;
        }
        throw new \InvalidArgumentException("{$attribute} is not valid attribute.");
    }

    public function get($attribute)
    {
        if (array_key_exists($attribute, $this->attributes)) {
            return $this->attributes[$attribute];
        }
        return '';
    }

    public function has($attribute)
    {
        return array_key_exists($attribute, $this->attributes);
    }

    public function remove($attribute)
    {
        unset($this->attributes[$attribute]);
    }

    public function getAttributes()
    {
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
        return $this;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        $this->set('id', $id);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->render();
    }
}
