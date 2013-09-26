<?php


class AF_NotEqualValidator extends AF_Validator
{

    private $neq;


    public function __construct($neq, $error = '')
    {
        parent::__construct($error);
        $this->neq = $neq;
        $error = strlen($error) ? $error : "Value must be different than $neq.";
        $this->setError($error);
    }


    public function validate(AF_Element $element)
    {
        return $element->value != $this->neq;
    }


}


?>