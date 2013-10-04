<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 14:30
 */

namespace Impreso\Container;

use Impreso\Renderer\Renderer;

class Base
{
    private $elements = array();
    private $renderer;

    public function addElement(\Impreso\Element\Base $element)
    {
        $element->set('id', $element->getName());
        $this->elements[$element->getName()] = $element;
        return $this;
    }

    /**
     * @return \Impreso\Element\Base[] array
     */
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
        return $this;
    }

    public function getData()
    {
        $result = array();
        foreach ($this->getElements() as $k => $v) {
            /* @var $v Base */
            $result[$v->getName()] = $v->getValue();
        }
        return $result;
    }

    public function hasElement($key)
    {
        return (isset($this->elements[$key]));
    }

    /**
     * @param $key
     * @return \Impreso\Element\Base
     * @throws \OutOfBoundsException
     */
    public function getElement($key)
    {
        if (!$this->hasElement($key)) {
            throw new \OutOfBoundsException("Element '$key' doesn't exists.");
        }
        return $this->elements[$key];
    }

    /**
     * @param Renderer $renderer
     */
    public function setRenderer(Renderer $renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }

    /**
     * @return Renderer
     */
    public function getRenderer()
    {
        return $this->renderer;
    }

    public function render()
    {
        return $this->getRenderer()->render($this);
    }

    public function __toString()
    {
        return (string)$this->render();
    }
}
