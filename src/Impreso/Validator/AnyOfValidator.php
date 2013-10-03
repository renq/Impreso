<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 03.10.13
 * Time: 12:55
 */

namespace Impreso\Validator;


class AnyOfValidator extends Validator
{

    private $validators = array();

    public function __construct($error, array $validators = array())
    {
        parent::__construct($error);
        $this->setValidators($validators);
    }

    public function setValidators(array $validators)
    {
        $this->validators = array();
        foreach ($validators as $v) {
            if (!$v instanceof Validator) {
                throw new \InvalidArgumentException('All validators must be instance of Impreso\Validator\Validator. Given: ' . get_class($v));
            }
            $this->validators[] = $v;
        }
    }

    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        $result = false;
        foreach ($this->validators as $validator) {
            if ($validator->validate($value)) {
                $result = true;
            }
        }
        return $result;
    }
}
