<?php


class AF_DatetimeValidator extends AF_Validator
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
        $regexValidator = new AF_RegexValidator('/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2} [0-9]{1,2}:[0-9]{2}|[0-9]{4}-[0-9]{1,2}-[0-9]{1,2} [0-9]{1,2}:[0-9]{2}:[0-9]{2}$/');
        return $regexValidator->validate($element);
    }


}


?>