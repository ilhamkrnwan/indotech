<?php
/**
 * Indotech Customizer Settings
 */

function indotech_customizer($wp_customize) {
    // ── Section: Hero ─────────────────────────────────────────────────────────
    $wp_customize->add_section('indotech_hero', [
        'title'    => __('Hero Section', 'indotech'),
        'priority' => 30,
    ]);

    $fields = [
        'hero_headline'  => ['Hero Headline', 'Supplier Homecare B2B Terpercaya di Indonesia'],
        'hero_sub'       => ['Hero Subtitle', 'Kami menyediakan produk homecare berkualitas untuk bisnis Anda. Grosir, distribusi, dan kemitraan B2B dengan harga kompetitif.'],
        'hero_cta1'      => ['CTA Button 1', 'Hubungi Kami'],
        'hero_cta1_url'  => ['CTA URL 1', '/kontak'],
        'hero_cta2'      => ['CTA Button 2', 'Lihat Produk'],
        'hero_cta2_url'  => ['CTA URL 2', '/produk'],
    ];

    foreach ($fields as $key => [$label, $default]) {
        $wp_customize->add_setting("indotech_{$key}", ['default' => $default, 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control("indotech_{$key}", ['label' => $label, 'section' => 'indotech_hero', 'type' => 'text']);
    }

    // ── Section: Contact Info ─────────────────────────────────────────────────
    $wp_customize->add_section('indotech_contact', [
        'title'    => __('Contact Information', 'indotech'),
        'priority' => 35,
    ]);

    $contact_fields = [
        'phone'    => ['Phone', '+62 21 1234 5678'],
        'email'    => ['Email', 'info@indotech.id'],
        'address'  => ['Address', 'Jakarta, Indonesia'],
        'whatsapp' => ['WhatsApp', '+6281234567890'],
    ];

    foreach ($contact_fields as $key => [$label, $default]) {
        $wp_customize->add_setting("indotech_{$key}", ['default' => $default, 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control("indotech_{$key}", ['label' => $label, 'section' => 'indotech_contact', 'type' => 'text']);
    }
}
add_action('customize_register', 'indotech_customizer');

function indotech_opt($key, $default = '') {
    return get_theme_mod("indotech_{$key}", $default);
}
