<?php
/**
 * Created by PhpStorm.
 * User: Michał Lipek
 * Date: 13.11.13
 * Time: 12:53
 */

namespace Impreso\Filter;


class CustomFilter implements Filter
{

    private $callable;

    public function __construct($callable)
    {
        $this->callable = $callable;
    }

    public function filter($value)
    {
        $function = $this->callable;
        return $function($value);
    }
}
