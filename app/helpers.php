<?php

if (!function_exists('format_amount')) {
    function format_amount($value, $decimals = 2): string
    {
        if (!is_numeric($value)) {
            return (string) $value;
        }
        if ((float) $value == floor((float) $value)) {
            return number_format((float) $value, 0, ',', '.');
        }
        return number_format((float) $value, $decimals, ',', '.');
    }
}

if (!function_exists('format_amount_short')) {
    function format_amount_short($value): string
    {
        return format_amount($value, 0);
    }
}
