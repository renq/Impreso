<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 09.10.13
 * Time: 13:15
 */

namespace Impreso\Validator;

class PasswordCharactersValidator extends Validator
{

    private $numberOfBigLetters;
    private $numberOfSmallLetters;
    private $numberOfDigits;
    private $numberOfSpecialChars;

    public function __construct($error = '', $numbersOfSmallLetters = 1, $numberOfBigLetters = 1, $numberOfDigits = 1, $numberOfSpecialChars = 0)
    {
        parent::__construct($error);
        $error = strlen($error) ? $error : "Passwords must have at least: {$numbersOfSmallLetters} small letters; {$numberOfBigLetters} big letters; {$numberOfDigits} digits and {$numberOfSpecialChars} special characters.";
        $this->setError($error);

        $this->numberOfSmallLetters = $numbersOfSmallLetters;
        $this->numberOfBigLetters = $numberOfBigLetters;
        $this->numberOfDigits = $numberOfDigits;
        $this->numberOfSpecialChars = $numberOfSpecialChars;
    }

    /**
     * @param int $numberOfSpecialChars
     * @return $this
     */
    public function setNumberOfSpecialChars($numberOfSpecialChars)
    {
        $this->numberOfSpecialChars = $numberOfSpecialChars;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumberOfSpecialChars()
    {
        return $this->numberOfSpecialChars;
    }

    /**
     * @param int $numberOfBigLetters
     * @return $this
     */
    public function setNumberOfBigLetters($numberOfBigLetters)
    {
        $this->numberOfBigLetters = $numberOfBigLetters;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumberOfBigLetters()
    {
        return $this->numberOfBigLetters;
    }

    /**
     * @param int $numberOfDigits
     * @return $this
     */
    public function setNumberOfDigits($numberOfDigits)
    {
        $this->numberOfDigits = $numberOfDigits;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumberOfDigits()
    {
        return $this->numberOfDigits;
    }

    /**
     * @param int $numberOfSmallLetters
     * @return $this
     */
    public function setNumberOfSmallLetters($numberOfSmallLetters)
    {
        $this->numberOfSmallLetters = $numberOfSmallLetters;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumberOfSmallLetters()
    {
        return $this->numberOfSmallLetters;
    }

    private function checkBigLetters($value)
    {
        return $this->check($value, '/[A-Z]/', $this->numberOfBigLetters);
    }

    private function checkSmallLetters($value)
    {
        return $this->check($value, '/[a-z]/', $this->numberOfSmallLetters);
    }

    private function checkDigits($value)
    {
        return $this->check($value, '/[0-9]/', $this->numberOfDigits);
    }

    private function checkSpecialChars($value)
    {
        return $this->check($value, '/[^A-Z0-9a-z]/', $this->numberOfSpecialChars);
    }

    private function check($value, $regex, $numberOf)
    {
        if ($numberOf < 1) {
            return true;
        }
        $matches = array();
        if (preg_match_all($regex, $value, $matches)) {
            if (count($matches[0]) >= $numberOf) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        return
            $this->checkBigLetters($value) &&
            $this->checkSmallLetters($value) &&
            $this->checkDigits($value) &&
            $this->checkSpecialChars($value);
    }
}
