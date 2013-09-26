<?php


class AF_EqualValidator extends AF_Validator
{

    private $eq;


    public function __construct($eq, $error = '')
    {
        parent::__construct($error);
        $this->eq = $eq;
        $error = strlen($error) ? $error : "Value must be equal $eq.";
        $this->setError($error);
    }


    public function validate(AF_Element $element)
    {
        return $element->value == $this->eq;
    }


}


?>