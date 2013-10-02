<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 13:25
 */
namespace Impreso\Element;

class Radio extends Input
{
    public function __construct($name = null)
    {
        parent::__construct('radio', $name);
    }
}
