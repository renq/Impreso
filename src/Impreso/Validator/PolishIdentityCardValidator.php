<?php
/**
 * Created by PhpStorm.
 * User: mlipek
 * Date: 27.05.15
 * Time: 16:55
 */

namespace Impreso\Validator;


class PolishIdentityCardValidator extends Validator
{

    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        return $this->checkPolishIdentityCardNumber($value);
    }

    private function checkPolishIdentityCardNumber($identityCard)
    {
        return
            $this->checkLength($identityCard) &&
            $this->checkChecksum($identityCard);
    }

    /**
     * @param $identityCard
     * @return bool
     */
    private function checkLength($identityCard)
    {
        return strlen($identityCard) == 9;
    }

    /**
     * @return array
     */
    private function getCharacterToValueMap()
    {
        return array(
            '0' => 0,  '1' => 1,  '2' => 2,  '3' => 3,  '4' => 4,  '5' => 5,  '6' => 6,  '7' => 7,  '8' => 8,
            '9' => 9,  'A' => 10, 'B' => 11, 'C' => 12, 'D' => 13, 'E' => 14, 'F' => 15, 'G' => 16, 'H' => 17,
            'I' => 18, 'J' => 19, 'K' => 20, 'L' => 21, 'M' => 22, 'N' => 23, 'O' => 24, 'P' => 25, 'Q' => 26,
            'R' => 27, 'S' => 28, 'T' => 29, 'U' => 30, 'V' => 31, 'W' => 32, 'X' => 33, 'Y' => 34, 'Z' => 35,
        );
    }

    /**
     * @return array
     */
    private function getWeightMap()
    {
        $importance = array(7, 3, 1, 0, 7, 3, 1, 7, 3);
        return $importance;
    }

    /**
     * @param $identityCard
     * @return bool|int
     */
    private function calculateChecksum($identityCard)
    {
        $identityCardNumber = strtoupper($identityCard);
        $characterToValueMap = $this->getCharacterToValueMap();
        $weightMap = $this->getWeightMap();

        $checksum = 0;
        for ($i = 0; $i < 9; $i++) {
            $currentValue = $characterToValueMap[$identityCardNumber[$i]];

            if ($i < 3 && $currentValue < 10) {
                return false;
            }
            elseif ($i > 2 && $currentValue > 9) {
                return false;
            }

            $checksum += ((int)$currentValue) * $weightMap[$i];
        }

        return $checksum;
    }

    /**
     * @param $identityCard
     * @param $checksum
     * @return bool
     */
    private function checkChecksum($identityCard)
    {
        $checksum = $this->calculateChecksum($identityCard);
        return $checksum % 10 == $identityCard[3];
    }

}
