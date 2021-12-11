<?php

namespace Baoweb\Helpers;

class Helpers
{
    // Build wonderful things

    public function formatNumber($number, $decimals = 2, $adjustPlaces = false) {

        $decimalSeparator = ',';
        $thousandsSeparator = ' ';

        $formattedNumber = number_format($number, $decimals, $decimalSeparator, $thousandsSeparator);

        if($adjustPlaces) {
            $formattedNumber = rtrim(rtrim($formattedNumber, '0'), $decimalSeparator);
        }

        return str_replace(' ', '&nbsp;', $formattedNumber);
    }
}
