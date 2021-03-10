<?php

namespace Tests\Unit;

use App\Services\NumericConverter\NumericConverter;
use PHPUnit\Framework\TestCase;

class NumericConverterTest extends TestCase
{
    public function test_numeric_conversion_10()
    {
        $numeric_converter = app()->make(NumericConverter::class);

        $this->assertEquals('X', $numeric_converter->convertToRoman(10));
    }

    public function test_numeric_conversion_3890()
    {
        $numeric_converter = app()->make(NumericConverter::class);

        $this->assertEquals('MMMDCCCXC', $numeric_converter->convertToRoman(3890));
    }

    public function test_numeric_conversion_5012()
    {
        $numeric_converter = app()->make(NumericConverter::class);

        $this->assertEquals('MMMMMXII', $numeric_converter->convertToRoman(5012));
    }

    public function test_numeric_conversion_132()
    {
        $numeric_converter = app()->make(NumericConverter::class);

        $this->assertEquals('CXXXII', $numeric_converter->convertToRoman(132));
    }
}
