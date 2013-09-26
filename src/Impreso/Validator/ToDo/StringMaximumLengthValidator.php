<?php


class AF_StringMaximumLengthValidator extends AF_Validator
{

    private $maximumLength;


    public function __construct($maximumLength, $error = '')
    {
        parent::__construct($error);
        $this->maximumLength = $maximumLength;
        $error = strlen($error) ? $error : "String must have minimum $maximumLength characters.";
        $this->setError($error);
    }


    public function validate(AF_Element $element)
    {
        return strlen($element->value) <= $this->maximumLength;
    }


}


?>