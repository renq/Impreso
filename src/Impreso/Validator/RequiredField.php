<?php

namespace Impreso\Validator;

use Impreso\Element\Element;

class RequiredField extends Validator
{

    public function __construct($error = '')
    {
        parent::__construct($error);
        $error = strlen($error) ? $error : 'Field is required';
        $this->setError($error);
    }

    public function validate(Element $element)
    {
        $value = $element->getValue();
        return (is_array($value) ? (bool)count($value) : strlen($value)) ? true : false;
    }
}
