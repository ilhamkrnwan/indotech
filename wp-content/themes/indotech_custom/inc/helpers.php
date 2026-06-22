<?php
/**
 * Indotech Custom Theme — Helper Utilities
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Format raw phone number into clean WhatsApp link numbers (e.g. +62 812-3456-7890 -> 6281234567890)
 *
 * @param string $phone Raw phone string.
 * @return string Clean numeric string.
 */
if (!function_exists('indotech_format_wa_number')) {
    function indotech_format_wa_number($phone) {
        $clean = preg_replace('/[^0-9]/', '', $phone);
        // Convert leading 0 to 62
        if (strpos($clean, '0') === 0) {
            $clean = '62' . substr($clean, 1);
        }
        return $clean;
    }
}
