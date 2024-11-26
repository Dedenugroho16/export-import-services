<?php

if (!function_exists('formatCurrency')) {
    function formatCurrency($value) {
        return number_format($value, 0, ',', ',');
    }
}

if (!function_exists('formatHarga')) {
    function formatHarga($value) {
        return number_format($value, 2, ',', '.');
    }
}

// kode untuk memformat product typenya string
// if (!function_exists('formatNCM')) {
//     function formatNCM($value) {
//         if (is_string($value)) {
//             $value = preg_replace('/\D/', '', $value);
//         }
//         return number_format((int) $value, 0, ',', ',');
//     }
// }