<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 03.10.13
 * Time: 09:38
 */

namespace Impreso\Validator;

class GreaterThanValidator extends Validator
{

    private $gt = null;

    /**
     * @param string $error
     * @param null $lte
     */
    public function __construct($error = '', $lte = null)
    {
        parent::__construct($error);
        if ($lte !== null) {
            $this->setGreaterThan($lte);
        }
    }

    /**
     * @param float|int $gt
     * @throws \InvalidArgumentException
     */
    public function setGreaterThan($gt)
    {
        if (!is_numeric($gt)) {
            throw new \InvalidArgumentException("setGreaterThan accepts only valid numbers. Given: " . $gt);
        }
        $this->gt = $gt;
    }

    /**
     * @param $value
     * @throws \UnexpectedValueException
     * @return bool
     */
    public function validate($value)
    {
        if (!is_numeric($this->gt)) {
            throw new \UnexpectedValueException("The \"greater than\" value should be a number. Given: (".(gettype($this->gt)).") " . $this->gt);
        }
        return $value > $this->gt;
    }
}
