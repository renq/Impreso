<?php

/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 10.10.13
 * Time: 13:26
 */
use Impreso\Container\Form;

class AF_Form extends Form
{

    public function add($type, $name, $label = false, $validators = array())
    {
        $class = $type;
        $class[0] = strtoupper($type[0]);
        $class = "Impreso\\Element\\{$class}";
        if (class_exists($class)) {
            $object = new $class($name);
            $object->setLabel($label);
            $object->addValidators(is_array($validators) ? $validators : array($validators) );

            $this->addElement($object);
            return $object;
        }
        else {
            throw new \RuntimeException("Class $class not found!");
        }
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function __set($name, $value)
    {
        if ($name == 'action') {
            return $this->setAction($value);
        }
        if ($name == 'method') {
            return $this->setMethod($value);
        }
        return $this->set($name, $value);
    }

    /**
     * @param $name
     * @return string
     */
    public function __get($name)
    {
        if ($name == 'action') {
            return $this->getAction();
        }
        return $this->get($name);
    }

    public function isSent() {
        $this->populate($_REQUEST);
        foreach ($_REQUEST as $k => $v) {
            $elements = $this->getElementsByName($k);
            if (!empty($elements)) {
                return true;
            }
        }
        return false;
    }
}