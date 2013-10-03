<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 03.10.13
 * Time: 09:38
 */

namespace Impreso\Validator;

class LessThanValidator extends Validator
{

    private $lt = null;

    /**
     * @param string $error
     * @param null $lte
     */
    public function __construct($error = '', $lte = null)
    {
        parent::__construct($error);
        if ($lte !== null) {
            $this->setLessThan($lte);
        }
    }

    /**
     * @param float|int $lt
     * @throws \InvalidArgumentException
     */
    public function setLessThan($lt)
    {
        if (!is_numeric($lt)) {
            throw new \InvalidArgumentException("setLessThan accepts only valid numbers. Given: " . $lt);
        }
        $this->lt = $lt;
    }

    /**
     * @param $value
     * @throws \UnexpectedValueException
     * @return bool
     */
    public function validate($value)
    {
        if (!is_numeric($this->lt)) {
            throw new \UnexpectedValueException("The \"less than\" value should be a number. Given: (".(gettype($this->lt)).") " . $this->lt);
        }
        return $value < $this->lt;
    }
}
