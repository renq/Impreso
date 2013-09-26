<?php


class AF_RegexValidator extends AF_Validator
{

    private $regex;


    public function __construct($regex, $error = '')
    {
        parent::__construct($error);
        $this->regex = $regex;
    }


    public function validate(AF_Element $element)
    {
        return preg_match($this->regex, $element->value);
    }


}


?>