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
        $rows = explode('&', http_build_query($data));
        foreach ($rows as $row) {
            list($key, $value) = array_map('urldecode', explode('=', $row));
            $elements = $this->getElementsByName($key);
            if (empty($elements) && $strict) {
                throw new \OutOfBoundsException("Element '$key' doesn't exists in form.");
            }
            foreach ($elements as $element) {
                /* @var $element \Impreso\Element\Element */
                $element->setValue($value);
            }
        }
        return $this;
    }

    public function getData()
    {
        $result = array();
        $tmp = array();
        foreach ($this->getElements() as $element) {
            /* @var $element \Impreso\Element\Base */
            $tmp[] = urlencode($element->getName()).'='.urlencode($element->getValue());
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
                $elementArrayName = str_replace("[$index]", '[]', $element->getName());
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
            trigger_error($e->getMessage(), E_USER_WARNING);
            return '';
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
