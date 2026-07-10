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
        'phone'    => ['Phone', '+62 856-0006-1005'],
        'email'    => ['Email', 'indotechberkahabadi@gmail.com'],
        'address'  => ['Address', 'Jongke Tengah No. 30, RT.01/RW.23, Sendangadi, Kec. Mlati, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55285'],
        'whatsapp' => ['WhatsApp', '6285600061005'],
    ];

    foreach ($contact_fields as $key => [$label, $default]) {
        $wp_customize->add_setting("indotech_{$key}", ['default' => $default, 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control("indotech_{$key}", ['label' => $label, 'section' => 'indotech_contact', 'type' => 'text']);
    }

    // ── Section: Testimonials ─────────────────────────────────────────────────
    $wp_customize->add_section('indotech_testimonials', [
        'title'    => __('Testimonials Section', 'indotech'),
        'priority' => 40,
    ]);

    $wp_customize->add_setting('indotech_testi_hover_bg', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'indotech_testi_hover_bg', [
        'label'    => __('Hover Background Image (Latar Belakang Toko)', 'indotech'),
        'section'  => 'indotech_testimonials',
        'settings' => 'indotech_testi_hover_bg',
    ]));
}
add_action('customize_register', 'indotech_customizer');

function indotech_opt($key, $default = '') {
    $val = get_theme_mod("indotech_{$key}", $default);
    if ($key === 'whatsapp' && ($val === '6285600061005' || empty($val))) {
        return '6287885590088'; // Default B2B Agent (CS Keagenan)
    }
    return $val;
}
