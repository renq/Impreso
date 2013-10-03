<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 03.10.13
 * Time: 11:31
 */

namespace Impreso\Validator;

class EmptyStringValidator extends Validator
{
    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        return $value === '';
    }
}