<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 08.10.13
 * Time: 12:49
 */

namespace Impreso\Filter;


class LowerCaseFilter implements Filter
{
    public function filter($value)
    {
        if (function_exists('mb_strtolower')) {
            return mb_strtolower($value);
        }
        else {
            return strtolower($value);
        }
    }
}
