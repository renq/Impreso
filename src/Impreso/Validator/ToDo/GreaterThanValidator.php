<?php


class AF_GreaterThanValidator extends AF_Validator
{

    private $gt;


    public function __construct($gt, $error = '')
    {
        parent::__construct($error);
        $this->gt = $gt;
        $error = strlen($error) ? $error : "Value must be greater than $gt.";
        $this->setError($error);
    }


    public function validate(AF_Element $element)
    {
        return $element->value > $this->gt;
    }


}


?>