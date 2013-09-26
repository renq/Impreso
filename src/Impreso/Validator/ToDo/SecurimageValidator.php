<?php


class AF_SecurimageValidator extends AF_Validator
{


    public function __construct($error = '')
    {
        parent::__construct($error);
    }


    public function validate(AF_Element $element)
    {
        if (class_exists('Securimage')) {
            $securimage = new Securimage();
            return $securimage->check($element->value);
        } else {
            die('AF_SecurimageValidator ERROR! Class Securimage not found.');
        }
    }


}


?>