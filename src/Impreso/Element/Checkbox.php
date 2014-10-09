<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 13:25
 */
namespace Impreso\Element;

class Checkbox extends Input
{
    public function __construct($name = null)
    {
        parent::__construct('checkbox', $name);
    }

    public function isChecked()
    {
        return (bool)$this->get('checked');
    }

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->set('checked', (bool)$value);
        return $this;
    }

    public function getValue()
    {
        return $this->filter(
            $this->isChecked() ? $this->get('value') : ''
        );
    }
}
