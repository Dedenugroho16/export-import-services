<?php

if (!function_exists('formatCurrency')) {
    function formatCurrency($value) {
        return number_format($value, 0, ',', '.');
    }
}