<?php
/**
 * Created by PhpStorm.
 * User: renq
 * Date: 22.01.14
 * Time: 12:53
 */

namespace Impreso\Validator;


class DateValidator extends Validator
{

    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        try {
            new \DateTime($value);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}