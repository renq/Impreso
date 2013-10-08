<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 08.10.13
 * Time: 12:46
 */

namespace Impreso\Filter;


class TrimFilter implements Filter
{

    public function filter($value)
    {
        return trim($value);
    }
}
