<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 02.10.13
 * Time: 14:07
 */

namespace Impreso\Validator;


class StringLengthValidator extends Validator
{

    private $minLength = null;
    private $maxLength = null;

    public function __construct($error, $minLength = null, $maxLength = null)
    {
        parent::__construct($error);
        $this->setMinLength($minLength);
        $this->setMaxLength($maxLength);
    }

    public function setMinLength($length)
    {
        if ($length === null) return;
        if (!is_int($length)) {
            throw new \InvalidArgumentException('Function setMinLength accepts only integer or null. Given: ' . gettype($length));
        }
        if ($length < 0) {
            throw new \InvalidArgumentException('minLength must be positive. Given: ' . $length);
        }
        $this->minLength = $length;
    }
    public function setMaxLength($length)
    {
        if ($length === null) return;
        if (!is_int($length)) {
            throw new \InvalidArgumentException('Function setMaxLength accepts only integer or null. Given: ' . gettype($length));
        }
        if ($length < 0) {
            throw new \InvalidArgumentException('maxLength must be positive. Given: ' . $length);
        }
        $this->maxLength = $length;
    }

    public function validate($value)
    {
        $result = true;
        if (is_int($this->minLength)) {
            $result = $result && ($this->minLength <= strlen($value));
        }
        if (is_int($this->maxLength)) {
            $result = $result && (strlen($value) <= $this->maxLength);
        }
        return $result;
    }
}
