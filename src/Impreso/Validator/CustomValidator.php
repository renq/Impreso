<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 09.10.13
 * Time: 13:45
 */

namespace Impreso\Validator;


class CustomValidator extends Validator
{

    private $function;

    /**
     * @param string $error
     * @param callable $function
     */
    public function __construct($error = '', $function = null)
    {
        parent::__construct($error);
        if ($function !== null) {
            $this->setFunction($function);
        }
    }

    /**
     * @param mixed $function
     * @throws \InvalidArgumentException
     * @return $this
     */
    public function setFunction($function)
    {
        if (!is_callable($function)) {
            throw new \InvalidArgumentException('Please set valid function.');
        }
        $this->function = $function;
        return $this;
    }

    /**
     * @param $value
     * @throws \InvalidArgumentException
     * @return bool
     */
    public function validate($value)
    {
        if (!is_callable($this->function)) {
            throw new \InvalidArgumentException('Please set valid function.');
        }
        $fun = $this->function;
        return (bool)$fun($value);
    }
}
