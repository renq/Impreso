<?php


class AF_FloatValidator extends AF_Validator
{


    public function __construct($error = '')
    {
        parent::__construct($error);
        $error = strlen($error) ? $error : 'Float only';
        $this->setError($error);
    }


    public function validate(AF_Element $element)
    {
        return preg_match('#^\-{0,1}[0-9]*\.[0-9]+$|^\-{0,1}[0-9]+$|^\-{0,1}[0-9]*\.$#', $element->value) ? true : false;
    }


}


?>