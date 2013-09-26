<?php


class AF_CheckedValidator extends AF_Validator
{


    public function __construct($error = '')
    {
        parent::__construct($error);
        $error = strlen($error) ? $error : 'Check this field';
        $this->setError($error);
    }


    public function validate(AF_Element $element)
    {
        $form = $element->getForm();
        $data = $form->getRequest();
        if (array_key_exists($element->getName(), $data)) {
            return true;
        }
        return false;
    }


}


?>