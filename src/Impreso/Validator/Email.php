<?php

namespace Impreso\Validator;

use Impreso\Element\Element;


class Email extends Validator
{

    public function __construct($error = '')
    {
        parent::__construct($error);
        $error = strlen($error) ? $error : "Incorrect email address.";
        $this->setError($error);
    }

    public function validate(Element $element)
    {
        return $this->verifyEmail($element->getValue());
    }

    protected function verifyEmail($email)
    {
        $wholeexp = '/^(.+?)@(([a-z0-9\.-]+?)\.[a-z]{2,6})$/i';
        $userexp = "/^[a-z0-9\~\!\#\$\%\&\(\)\-\_\+\=\[\]\;\:\'\"\,\.\/]+$/i";
        if (preg_match($wholeexp, $email, $regs)) {
            $username = $regs[1];
            if (preg_match($userexp, $username)) {
                return true;
            }
        }
        return false;
    }
}
