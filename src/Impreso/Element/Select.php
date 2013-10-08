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
            if (is_array($v)) {

                $optionsGroup = new HtmlElement('optgroup', '', array(
                    'label' => $k,
                ));
                foreach ($v as $k2 => $v2) {
                    $optionAttributes['value'] = $k2;
                    if ($k2 === $this->getValue()) {
                        $optionAttributes['selected'] = true;
                    }
                    $option = new HtmlElement('option', $v2, $optionAttributes);
                    $optionsGroup->setText($optionsGroup->getText() . $option);
                }
                $options .= $optionsGroup;
            }
            else {
                $optionAttributes['value'] = $k;
                if ($k === $this->getValue()) {
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
        if ($this->isSimple()) {
            if (!array_key_exists($value, $this->data)) {
                throw new \InvalidArgumentException("Key '$value' in Impreso\\Element\\Select '{$this->getName()}' data doesn't exists!");
            }
        }
        else {
            $found = false;
            foreach ($this->data as $v) {
                if (array_key_exists($value, $v)) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                throw new \InvalidArgumentException("Key '$value' in Impreso\\Element\\Select '{$this->getName()}' data doesn't exists!");
            }
        }
        $this->value = (string)$value;
        return $this;
    }

    public function getValue()
    {
        return $this->filter(
            $this->value
        );
    }

    private function isSimple()
    {
        if (empty($this->data)) {
            return true;
        }
        if (is_array(reset($this->data))) {
            return false;
        }
        return true;
    }
}
