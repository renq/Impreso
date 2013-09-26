<?php


class AF_FileExistsValidator extends AF_Validator
{


    public function __construct($error = '')
    {
        parent::__construct($error);
        $error = strlen($error) ? $error : 'Upload a file.';
        $this->setError($error);
    }


    public function validate(AF_Element $element)
    {
        $name = $element->getName();
        $data = $element->getForm()->getFileData();
        if (is_array($_FILES[$name])) {
            if (is_uploaded_file($_FILES[$name]['tmp_name'])) {
                return true;
            }
        }
        return false;
    }


}


?>