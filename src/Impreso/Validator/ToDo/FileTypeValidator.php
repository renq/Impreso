<?php


class AF_FileTypeValidator extends AF_Validator
{


    public function __construct($error = '', $fileType = '')
    {
        parent::__construct($error);
        $this->fileType = $fileType;
        $error = strlen($error) ? $error : 'Bad file type!';
        $this->setError($error);
    }


    public function validate(AF_Element $element)
    {
        $name = $element->getName();
        if (is_array($_FILES[$name])) {
            if ($_FILES[$name]['type'] == $this->fileType) {
                return true;
            }
        }
        return false;
    }


}


?>