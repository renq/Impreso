<?php

namespace Impreso\Validator;

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

    /**
     * @param $value
     * @return bool
     */
    abstract public function validate($value);
}
