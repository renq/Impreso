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
    private $options = array();

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->setValidAttributes(array_merge($this->getValidAttributes(), array('multiple')));
    }

    public function render()
    {
        $attributes = $this->getAttributes();
        $options = '';
        foreach ($this->getOptions() as $k => $v) {

            if (is_array($v)) {
                $optionsGroup = new HtmlElement('optgroup', '', array(
                    'label' => $k,
                ));
                foreach ($v as $k2 => $v2) {
                    $optionAttributes = array();
                    $optionAttributes['value'] = $k2;
                    if ($k2 == $this->getValue() || is_array($this->getValue()) && in_array($k2, $this->getValue())) {
                        $optionAttributes['selected'] = true;
                    }
                    $option = new HtmlElement('option', $v2, $optionAttributes);
                    $optionsGroup->setText($optionsGroup->getText() . $option);
                }
                $options .= $optionsGroup;
            }
            else {
                $optionAttributes = array();
                $optionAttributes['value'] = $k;
                if ($k == $this->getValue() || is_array($this->getValue()) && in_array($k, $this->getValue())) {
                    $optionAttributes['selected'] = true;
                }
                $options .= (string)(new HtmlElement('option', $v, $optionAttributes));
            }
        }

        return (string)(new HtmlElement('select', $options, $attributes));
    }

    /**
     * @param string $value
     * @throws \InvalidArgumentException
     * @return $this
     */
    public function setValue($value)
    {
        if (is_array($value)) {
            return $this->setValues($value);
        }

        $options = $this->options;
        if (!$this->isSimple()) {
            $options = call_user_func_array('array_merge', $options);
        }

        if (!array_key_exists($value, $options)) {
            throw new \InvalidArgumentException("Key '$value' in Impreso\\Element\\Select '{$this->getName()}' options doesn't exists!");
        }

        $this->value = (string)$value;
        return $this;
    }

    public function setValues(array $values)
    {
        $options = $this->options;
        if (!$this->isSimple()) {
            $options = call_user_func_array('array_merge', $options);
        }

        $this->value = array();
        foreach ($values as $value) {
            if (!array_key_exists($value, $options)) {
                throw new \InvalidArgumentException("Key '$value' in Impreso\\Element\\Select '{$this->getName()}' options doesn't exists!");
            }
            $this->value[] = $value;
        }
        return $this;
    }

    public function getValue()
    {
        return $this->filter(
            $this->value
        );
    }

    function getRawValue()
    {
        return $this->value;
    }

    private function isSimple()
    {
        if (is_array(reset($this->options))) {
            return false;
        }
        return true;
    }

    public function isArrayType()
    {
        return $this->has('multiple');
    }
}
