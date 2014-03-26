<?php
/**
 * Created by PhpStorm.
 * User: Michał Lipek
 * Date: 26.03.14
 * Time: 12:55
 */

namespace Impreso\Filter;


class IntegerFilter implements Filter
{

    public function filter($value)
    {
        return (int)$value;
    }
}
