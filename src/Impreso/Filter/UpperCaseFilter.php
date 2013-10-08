<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 08.10.13
 * Time: 12:49
 */

namespace Impreso\Filter;


class UpperCaseFilter implements Filter
{
    public function filter($value)
    {
        if (function_exists('mb_strtoupper')) {
            return mb_strtoupper($value);
        }
        else {
            return strtoupper($value);
        }
    }
}
