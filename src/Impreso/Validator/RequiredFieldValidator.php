<?php

namespace Impreso\Validator;


class RequiredFieldValidator extends Validator
{

    public function __construct($error = '')
    {
        parent::__construct($error);
        $error = strlen($error) ? $error : 'Field is required';
        $this->setError($error);
    }

    public function validate($value)
    {
        return (is_array($value) ? (bool)count($value) : strlen($value)) ? true : false;
    }
}
