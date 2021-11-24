<?php

namespace Baoweb\Helpers;

class Helpers
{
    // Build wonderful things

    public function formatNumber($number, $decimals = 2) {
        $formattedNumber = number_format($number, $decimals, ',', ' ');

        return str_replace(' ', '&nbsp;', $formattedNumber);
    }
}
