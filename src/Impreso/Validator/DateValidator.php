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
            $dt = new \DateTime($value);
            $errors = $dt->getLastErrors();
            if ($errors['error_count'] + $errors['warning_count'] || strpos($value, '0000-00-00') === 0) {
                return false;
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}