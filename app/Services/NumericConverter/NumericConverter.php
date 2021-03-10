<?php


namespace App\Services\NumericConverter;

use App\Services\NumericConverter\ConverterTypes\IntToRoman;

class NumericConverter implements NumericConverterInterface
{
    use IntToRoman;
}
