<?php


class AF_DateValidator extends AF_Validator
{

    private $lt;


    public function __construct($error = '')
    {
        parent::__construct($error);
        $error = strlen($error) ? $error : "Enter correct date in format YYYY-MM-DD HH:MM:SS.";
        $this->setError($error);
    }


    public function validate(AF_Element $element)
    {
        if (!preg_match('/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/', $element->value)) return false;
        list($y, $m, $d) = explode('-', $element->value);
        return checkdate($m, $d, $y);
    }


}


