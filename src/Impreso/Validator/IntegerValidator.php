<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 03.10.13
 * Time: 11:47
 */

namespace Impreso\Validator;


class IntegerValidator extends Validator
{
    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        return preg_match('/^[-+]{0,1}[0-9]+$/', (string)$value) ? true : false;
    }
}
