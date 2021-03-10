<?php

namespace App\Services\NumericConverter\ConverterTypes;

trait IntToRoman
{
    /**
     * Convert int to roman
     * @param int $number
     * @return string
     */
    public function convertToRoman(int $number) : string
    {
        //list of roman to arabic
        $roman_map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);

        //convert int to roman
        $roman_conversion = '';
        //check if we still have a value to convert
        while ($number > 0) {
            foreach ($roman_map as $roman_value => $int) {

                // start with biggest roman values and reduce it to smallest
                if($number >= $int) {
                    $roman_conversion .= $roman_value;

                    //reduce the converted value
                    $number -= $int;
                    break;
                }
            }
        }

        return $roman_conversion;
    }
}
