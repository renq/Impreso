<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 13:25
 */
namespace Impreso\Element;

class Submit extends Input
{
    private $sent = '';

    public function __construct($name = null)
    {
        parent::__construct('submit', $name);
    }

    public function setValue($value)
    {
        $this->sent = $value;
    }

    public function getValue()
    {
        return $this->sent;
    }
}
