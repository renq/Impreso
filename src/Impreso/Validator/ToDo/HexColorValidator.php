<?php


class AF_HexColorValidator extends AF_Validator
{


    public function __construct($error = '')
    {
        parent::__construct($error);
    }


    public function validate(AF_Element $element)
    {
        return preg_match('/^[a-f0-9]{6}$|^[a-f0-9]{3}$/i', $element->value);
    }


}


?>