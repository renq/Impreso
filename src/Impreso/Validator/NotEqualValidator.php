<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 03.10.13
 * Time: 09:38
 */

namespace Impreso\Validator;

class NotEqualValidator extends Validator
{

    private $neq = null;

    /**
     * @param string $error
     * @param mixed $eq
     */
    public function __construct($error = '', $eq = null)
    {
        parent::__construct($error);
        $this->setNotEqual($eq);
    }

    /**
     * @param mixed $neq
     */
    public function setNotEqual($neq)
    {
        $this->neq = $neq;
    }

    /**
     * @param $value
     * @throws \UnexpectedValueException
     * @return bool
     */
    public function validate($value)
    {
        return $value != $this->neq;
    }
}
