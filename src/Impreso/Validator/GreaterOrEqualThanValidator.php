<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 03.10.13
 * Time: 09:38
 */

namespace Impreso\Validator;

class GreaterOrEqualThanValidator extends Validator
{

    private $gte = null;

    /**
     * @param string $error
     * @param null $lte
     */
    public function __construct($error = '', $lte = null)
    {
        parent::__construct($error);
        if ($lte !== null) {
            $this->setGreaterOrEqualThan($lte);
        }
    }

    /**
     * @param float|int $gte
     * @throws \InvalidArgumentException
     */
    public function setGreaterOrEqualThan($gte)
    {
        if (!is_numeric($gte)) {
            throw new \InvalidArgumentException("setGreaterOrEqualThan accepts only valid numbers. Given: " . $gte);
        }
        $this->gte = $gte;
    }

    /**
     * @param $value
     * @throws \UnexpectedValueException
     * @return bool
     */
    public function validate($value)
    {
        if (!is_numeric($this->gte)) {
            throw new \UnexpectedValueException("The \"greater or equal than\" value should be a number. Given: (".(gettype($this->gte)).") " . $this->gte);
        }
        return $value >= $this->gte;
    }
}
