<?php

namespace Baoweb\Helpers;

use Carbon\Carbon;

class DateHelpers
{
    // Build wonderful things

    public function weekDaysInAMonth($year, $month): int
    {
        // Create a Carbon date for the start and end of the month
        $start = Carbon::create($year, $month);
        $end = Carbon::create($year, $month)->endOfMonth();

        $weekdays = 0;

        // Loop from the start to end of the month
        for ($date = $start; $date->lte($end); $date->addDay()) {
            // If the current day is weekday, increment counter
            if ($date->isWeekday()) {
                $weekdays++;
            }
        }

        return $weekdays;
    }
}
