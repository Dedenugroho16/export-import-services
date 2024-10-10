<?php

namespace App\Helpers;

class NumberToWords {
    public static function convert($number) {
        $words = [
            '0' => 'zero', '1' => 'one', '2' => 'two', '3' => 'three', 
            '4' => 'four', '5' => 'five', '6' => 'six', '7' => 'seven', 
            '8' => 'eight', '9' => 'nine', '10' => 'ten', 
            '11' => 'eleven', '12' => 'twelve', '13' => 'thirteen', 
            '14' => 'fourteen', '15' => 'fifteen', '16' => 'sixteen', 
            '17' => 'seventeen', '18' => 'eighteen', '19' => 'nineteen', 
            '20' => 'twenty', '30' => 'thirty', '40' => 'forty', 
            '50' => 'fifty', '60' => 'sixty', '70' => 'seventy', 
            '80' => 'eighty', '90' => 'ninety'
        ];
        
        if ($number < 100) {
            if ($number < 21) {
                return $words[$number];
            }
            $tens = floor($number / 10) * 10;
            $units = $number % 10;
            return $units ? $words[$tens] . ' ' . $words[$units] : $words[$tens];
        }
        
        if ($number < 1000) {
            $hundreds = floor($number / 100);
            $remainder = $number % 100;
            return $words[$hundreds] . ' hundred' . ($remainder ? ' ' . self::convert($remainder) : '');
        }
        
        // Handle thousands and beyond as needed.
        $thousands = floor($number / 1000);
        $remainder = $number % 1000;
        return self::convert($thousands) . ' thousand' . ($remainder ? ' ' . self::convert($remainder) : '');
    }
}