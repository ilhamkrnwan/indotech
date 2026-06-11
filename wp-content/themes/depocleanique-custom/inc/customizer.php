<?php
/**
 * Depocleanique Custom — inc/customizer.php
 *
 * Registrasi WordPress Customizer untuk data global theme.
 *
 * Cara akses: Appearance → Customize → Depo Cleanique
 *
 * Struktur:
 *   Panel "Depo Cleanique"
 *   ├── Section: WhatsApp & Kontak  (dc_wa_number, dc_wa_label, dc_email, dc_address, dc_business_hours)
 *   └── Section: Media Sosial       (dc_social_instagram, dc_social_facebook, dc_social_tiktok)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'customize_register', 'depocleanique_customizer_register' );

/**
 * @param WP_Customize_Manager $wp_customize
 */
function depocleanique_customizer_register( $wp_customize ) {

    /* ── Panel utama ─────────────────────────────────── */
    $wp_customize->add_panel( 'dc_panel', [
        'title'       => __( 'Depo Cleanique', 'depocleanique-custom' ),
        'description' => __( 'Pengaturan global theme: WhatsApp, kontak, alamat, dan media sosial. Nilai di sini akan tampil di seluruh halaman.', 'depocleanique-custom' ),
        'priority'    => 30,
    ] );


    /* ══════════════════════════════════════════════════
     * Section 1 — WhatsApp & Kontak
     * ══════════════════════════════════════════════════ */
    $wp_customize->add_section( 'dc_contact_section', [
        'title'    => __( 'WhatsApp & Kontak', 'depocleanique-custom' ),
        'panel'    => 'dc_panel',
        'priority' => 10,
    ] );

    // ── Nomor WhatsApp ─────────────────────────────
    $wp_customize->add_setting( 'dc_wa_number', [
        'default'           => '6285600061005',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'dc_wa_number', [
        'label'       => __( 'Nomor WhatsApp', 'depocleanique-custom' ),
        'description' => __( 'Tanpa tanda +, spasi, atau strip. Contoh: 6285600061005', 'depocleanique-custom' ),
        'section'     => 'dc_contact_section',
        'type'        => 'text',
        'input_attrs' => [ 'placeholder' => '6285600061005' ],
    ] );

    // ── Label Tampil Nomor WA ──────────────────────
    $wp_customize->add_setting( 'dc_wa_label', [
        'default'           => '0856-0006-1005',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'dc_wa_label', [
        'label'       => __( 'Label Tampil WhatsApp', 'depocleanique-custom' ),
        'description' => __( 'Format cantik yang ditampilkan ke pengunjung. Contoh: 0856-0006-1005', 'depocleanique-custom' ),
        'section'     => 'dc_contact_section',
        'type'        => 'text',
        'input_attrs' => [ 'placeholder' => '0856-0006-1005' ],
    ] );

    // ── Email ──────────────────────────────────────
    $wp_customize->add_setting( 'dc_email', [
        'default'           => 'hello@depocleanique.com',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'dc_email', [
        'label'       => __( 'Email', 'depocleanique-custom' ),
        'section'     => 'dc_contact_section',
        'type'        => 'email',
        'input_attrs' => [ 'placeholder' => 'hello@depocleanique.com' ],
    ] );

    // ── Alamat ─────────────────────────────────────
    $wp_customize->add_setting( 'dc_address', [
        'default'           => "Jongke Tengah No. 30 RT.01/RW.23\nMlati, Sleman\nYogyakarta 55285\nIndonesia",
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'dc_address', [
        'label'       => __( 'Alamat Lengkap', 'depocleanique-custom' ),
        'description' => __( 'Tekan Enter untuk pindah baris. Akan ditampilkan sebagai address di seluruh halaman.', 'depocleanique-custom' ),
        'section'     => 'dc_contact_section',
        'type'        => 'textarea',
    ] );

    // ── Jam Operasional ────────────────────────────
    $wp_customize->add_setting( 'dc_business_hours', [
        'default'           => 'Senin – Sabtu, 08.00 – 21.00 WIB',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'dc_business_hours', [
        'label'       => __( 'Jam Operasional', 'depocleanique-custom' ),
        'section'     => 'dc_contact_section',
        'type'        => 'text',
        'input_attrs' => [ 'placeholder' => 'Senin – Sabtu, 08.00 – 21.00 WIB' ],
    ] );


    /* ══════════════════════════════════════════════════
     * Section 2 — Media Sosial
     * ══════════════════════════════════════════════════ */
    $wp_customize->add_section( 'dc_social_section', [
        'title'    => __( 'Media Sosial', 'depocleanique-custom' ),
        'panel'    => 'dc_panel',
        'priority' => 20,
    ] );

    $social_items = [
        'instagram' => __( 'URL Instagram', 'depocleanique-custom' ),
        'facebook'  => __( 'URL Facebook',  'depocleanique-custom' ),
        'tiktok'    => __( 'URL TikTok',    'depocleanique-custom' ),
    ];

    foreach ( $social_items as $key => $label ) {
        $wp_customize->add_setting( 'dc_social_' . $key, [
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ] );
        $wp_customize->add_control( 'dc_social_' . $key, [
            'label'       => $label,
            'description' => __( 'URL lengkap. Isi # jika tidak ada akun.', 'depocleanique-custom' ),
            'section'     => 'dc_social_section',
            'type'        => 'url',
            'input_attrs' => [ 'placeholder' => 'https://' ],
        ] );
    }
}
