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

/**
 * Get brand logo URL based on brand name
 *
 * @param string $brand_title The brand name/title.
 * @return string The brand logo URL or empty string.
 */
if (!function_exists('indotech_get_brand_logo_url')) {
    function indotech_get_brand_logo_url($brand_title) {
        $logo_mapping = [
            'cleanique academy' => 'cleaniqueacademy.webp',
            'cleanique lab'     => 'cleaniquelab.webp',
            'cleanique mart'    => 'cleaniquemart.webp',
            'depo cleanique'    => 'depocleanique.webp',
            'malabeez'          => 'malabeez.png',
            'orchid care'       => 'orchidcare.png',
            'prokopi'           => 'prokopi.png',
        ];
        
        $key = strtolower(trim($brand_title));
        if (isset($logo_mapping[$key])) {
            return get_template_directory_uri() . '/assets/images/' . $logo_mapping[$key];
        }
        return '';
    }
}
