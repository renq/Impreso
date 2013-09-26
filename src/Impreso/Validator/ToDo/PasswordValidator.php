<?php


class AF_PasswordValidator extends AF_Validator
{


    private $secondPassword = null;


    public function __construct($error = '', AF_PasswordElement $secondPasswordElement)
    {
        parent::__construct($error);
        $error = strlen($error) ? $error : "Passwords must be equal.";
        $this->setError($error);
        $this->secondPassword = $secondPasswordElement;
    }


    public function validate(AF_Element $element)
    {
        return $element->value == $this->secondPassword->value;
    }


}


?>