<?php

namespace App\Services\NumericConverter;

interface NumericConverterInterface
{
    /**
     * Convert int to roman
     * @param int $number
     * @return string
     */
    public function convertToRoman(int $number): string;
}
