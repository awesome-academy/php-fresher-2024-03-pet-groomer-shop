<?php

if (!function_exists('formatDate')) {
    function formatDate($date, string $format = 'd/m/Y')
    {
        // If $date is a string, parse it into a Carbon instance
        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        }

        // If $date is a Carbon instance, format it
        if ($date instanceof \Carbon\Carbon) {
            return $date->format($format);
        }

        // Return the original value if it's not a string or Carbon instance
        return $date;
    }
}

if (!function_exists('flashMessage')) {
    function flashMessage(string $type, string $message)
    {
        session()->flash($type, $message);
    }
}
