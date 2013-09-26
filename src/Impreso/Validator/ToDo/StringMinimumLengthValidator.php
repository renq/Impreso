<?php


class AF_StringMinimumLengthValidator extends AF_Validator
{

    private $minimumLength;


    public function __construct($minimumLength, $error = '')
    {
        parent::__construct($error);
        $this->minimumLength = $minimumLength;
        $error = strlen($error) ? $error : "String must have minimum $minimumLength characters.";
        $this->setError($error);
    }


    public function validate(AF_Element $element)
    {
        return strlen($element->value) >= $this->minimumLength;
    }


}


?>