<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 02.10.13
 * Time: 16:30
 */

namespace Impreso\Validator;


class RegexValidator extends Validator
{

    private $regex;

    public function __construct($error, $regex = null)
    {
        parent::__construct($error);
        $this->setRegex($regex);
    }

    public function setRegex($regex)
    {
        $this->regex = $regex;
    }

    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        $result = @preg_match($this->regex, $value);
        if ($result === false) {
            throw new \InvalidArgumentException("Incorrect regular expression: $this->regex");
        }
        return (bool)$result;
    }
}
