<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 14:30
 */

namespace Impreso\Container;

use Impreso\Renderer\Renderer;
use Impreso\Element\Base as ElementBase;

class Base extends ElementBase
{
    private $elements = array();
    private $renderer;

    public function addElement(\Impreso\Element\Base $element)
    {
        if (!$element->getId()) {
            $element->setId($this->stringToId($element->getName()));
        }
        $this->elements[$element->getId()] = $element;
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
        $rows = empty($data) ? array() : explode('&', http_build_query($data));
        foreach ($rows as $row) {
            list($key, $value) = array_map('urldecode', explode('=', $row));
            $elements = $this->getElementsByName($key);
            if (empty($elements) && $strict) {
                throw new \OutOfBoundsException("Element '$key' doesn't exists in form.");
            }
            foreach ($elements as $element) {
                /* @var $element \Impreso\Element\Element */
                if ($element->isArrayType()) {
                    // I'm not proud of this code, but it works... TODO refactor this
                    $element->setValue($data[substr($key, 0, -3)]);
                    continue;
                }
                else {
                    $element->setValue($value);
                }
            }
        }
        return $this;
    }

    public function getData()
    {
        $result = array();
        $tmp = array();
        foreach ($this->getElements() as $element) {
            /* @var $element \Impreso\Element\Element */
            if ($element->has('disabled')) continue;
            $value = $element->getValue();
            if (is_array($value)) {
                foreach ($value as $v) {
                    $tmp[] = urlencode($element->getName()).'='.urlencode($v);
                }
            }
            else {
                $tmp[] = urlencode($element->getName()).'='.urlencode($element->getValue());
            }
        }
        parse_str(implode('&', $tmp), $result);
        return $result;
    }

    public function hasElement($id)
    {
        return (isset($this->elements[$id]));
    }

    /**
     * @param $name
     * @return \Impreso\Element\Base[]
     */
    public function getElementsByName($name)
    {
        $result = array();
        foreach ($this->getElements() as $element) {
            if ($element->getName() == $name) {
                $result[] = $element;
            }
        }

        // try find arrays
        if (empty($result)) {
            if (preg_match('/\[([0-9]+)\]$/', $name, $matches)) {
                $index = (int)$matches[1];
                $elementArrayName = str_replace("[$index]", '[]', $name);
                $arrayElements = array();
                foreach ($this->getElements() as $element) {
                    if ($element->getName() == $elementArrayName) {
                        $arrayElements[] = $element;
                    }
                }

                if (isset($arrayElements[$index])) {
                    $result[] = $arrayElements[$index];
                }
            }
        }

        return $result;
    }

    /**
     * @param $id
     * @return \Impreso\Element\Base
     * @throws \OutOfBoundsException
     */
    public function getElement($id)
    {
        if (!$this->hasElement($id)) {
            throw new \OutOfBoundsException("Element '$id' doesn't exists.");
        }
        return $this->elements[$id];
    }

    /**
     * @param Renderer $renderer
     * @return $this
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
        if (!$this->getRenderer() instanceof Renderer) {
            throw new \UnexpectedValueException('No renderer. Set renderer first using setRenderer() method.');
        }
        return $this->getRenderer()->render($this);
    }

    public function __toString()
    {
        try {
            return (string)$this->render();
        }
        catch (\UnexpectedValueException $e) {
            return 'ERROR (Exception): ' . $e->getMessage();
        }
    }

    protected function stringToId($string){
        $id = preg_replace('/[^0-9a-z_-]/', '', $string);
        $num = 0;
        $result = $id;
        while ($this->hasElement($result)) {
            $num++;
            $result = $id . $num;
        }
        return $result;
    }
}
