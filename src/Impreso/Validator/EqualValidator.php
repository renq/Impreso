<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 03.10.13
 * Time: 09:38
 */

namespace Impreso\Validator;

class EqualValidator extends Validator
{

    private $eq = null;

    /**
     * @param string $error
     * @param mixed $eq
     */
    public function __construct($error = '', $eq = null)
    {
        parent::__construct($error);
        $this->setEqual($eq);
    }

    /**
     * @param mixed $eq
     */
    public function setEqual($eq)
    {
        $this->eq = $eq;
    }

    /**
     * @param $value
     * @throws \UnexpectedValueException
     * @return bool
     */
    public function validate($value)
    {
        return $value == $this->eq;
    }
}
