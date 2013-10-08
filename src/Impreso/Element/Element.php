<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 13:39
 */

namespace Impreso\Element;


use Impreso\Filter\Filter;
use Impreso\Validator\Validator;

abstract class Element extends Base
{

    private $validate = true;
    private $validateErrors = array();
    private $label;
    private $validators = array();
    private $filters = array();

    public function __construct($name = null)
    {
        $this->setValidAttributes(
            array(
                'id', 'class', 'title', 'style', 'dir', 'lang', 'xml:lang', 'tabindex', 'accesskey',
                'onfocus', 'onblur', 'onselect', 'onchange', 'onclick', 'ondblclick', 'onmousedown', 'onmouseup',
                'onmouseover', 'onmousemove', 'onmouseout', 'onkeypress', 'onkeydown', 'onkeyup',
                'accept', 'align', 'alt', 'checked', 'disabled', 'maxlength', 'name', 'readonly', 'size',
                'src', 'type', 'value', 'placeholder',
            )
        );
        if ($name) {
            $this->setName($name);
        }
    }

    /**
     * @param Validator $validator
     * @return $this
     */
    public function addValidator(Validator $validator)
    {
        $this->validators[] = $validator;
        return $this;
    }

    /**
     * Gets an array of validators.
     * @return array
     */
    public function getValidators()
    {
        return $this->validators;
    }

    /**
     * @return $this
     */
    public function clearValidators()
    {
        $this->validators = array();
        return $this;
    }

    /**
     * @param Filter $filter
     * @return $this
     */
    public function addFilter(Filter $filter)
    {
        $this->filters[] = $filter;
        return $this;
    }

    /**
     * @return Filter[]
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @return $this
     */
    public function clearFilters()
    {
        $this->filters = array();
        return $this;
    }

    protected function filter($value)
    {
        $result = $value;
        foreach ($this->getFilters() as $filter) {
            $result = $filter->filter($result);
        }
        return $result;
    }

    public function validate()
    {
        if (!$this->validate) return true;

        $result = true;
        $this->validateErrors = array();

        foreach ($this->validators as $validator) {
            $tmp = $validator->validate($this->getValue());
            if (!$tmp) {
                $result = false;
                $this->addError($validator->getError());
            }
        }
        return $result;
    }

    public function addError($error) {
        $this->validateErrors[] = $error;
    }

    /**
     * Return all validation errors
     *
     * @return array array of string
     */
    public function getErrors() {
        return $this->validateErrors;
    }

    /**
     * @param mixed $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param array $exclude
     * @return string
     * @deprecated
     */
    protected function getAttributesString($exclude = array())
    {
        $result = '';
        $exclude = (array)$exclude;
        foreach ($this->getAttributes() as $k => $v) {
            if (!is_array($v) && !in_array($k, $exclude)) {
                $v = $this->valueEntities($v);
                $result .= "$k=\"$v\" ";
            }
        }
        return trim($result);
    }

    protected function valueEntities($text)
    {
        return htmlentities($text, ENT_COMPAT, 'UTF-8');
    }

    abstract function render();

    abstract function setValue($value);

    abstract function getValue();
}
