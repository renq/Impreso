<?php


class AF_EmptyStringValidator extends AF_Validator
{


    public function __construct($error = '')
    {
        parent::__construct($error);
        $error = strlen($error) ? $error : 'Empty string only.';
        $this->setError($error);
    }


    public function validate(AF_Element $element)
    {
        return $element->value === '';
    }


}


?>