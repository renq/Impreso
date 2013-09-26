<?php

namespace Impreso\Validator;

use Impreso\Element\Element;

abstract class Validator
{

    protected $error = 'undefined error';

    public function __construct($error = '')
    {
        $this->setError($error);
    }

    public function getError()
    {
        return $this->error;
    }

    public function setError($message)
    {
        $this->error = $message;
    }

    abstract public function validate(Element $element);
}
