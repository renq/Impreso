<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 03.10.13
 * Time: 09:38
 */

namespace Impreso\Validator;

class LessOrEqualThanValidator extends Validator
{

    private $lte = null;

    /**
     * @param string $error
     * @param null $lte
     */
    public function __construct($error = '', $lte = null)
    {
        parent::__construct($error);
        if ($lte !== null) {
            $this->setLessOrEqualThan($lte);
        }
    }

    /**
     * @param float|int $lte
     * @throws \InvalidArgumentException
     */
    public function setLessOrEqualThan($lte)
    {
        if (!is_numeric($lte)) {
            throw new \InvalidArgumentException("setLessThan accepts only valid numbers. Given: " . $lte);
        }
        $this->lte = $lte;
    }

    /**
     * @param $value
     * @throws \UnexpectedValueException
     * @return bool
     */
    public function validate($value)
    {
        if (!is_numeric($this->lte)) {
            throw new \UnexpectedValueException("The \"less than\" value should be a number. Given: (".(gettype($this->lte)).") " . $this->lte);
        }
        return $value <= $this->lte;
    }
}
