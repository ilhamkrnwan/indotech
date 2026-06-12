<?php
/**
 * Depocleanique Custom — inc/helpers.php
 *
 * Helper functions untuk mengambil data global theme.
 * Semua nilai diambil dari WordPress Customizer (theme_mod) dengan fallback yang aman.
 *
 * Cara ubah nilai: Appearance → Customize → Depo Cleanique
 *
 * Cara pakai di template:
 *   echo esc_url( dc_get_wa_url( 'hero' ) );
 *   echo esc_html( dc_get_email() );
 *   echo dc_get_address_html(); // sudah di-escape, langsung echo
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/* ─── WhatsApp ───────────────────────────────────────── */

/**
 * Nomor WhatsApp mentah (tanpa + atau spasi).
 * Diambil dari Customizer. Fallback: '6285600061005'.
 *
 * @return string
 */
function dc_get_wa_number() {
    return get_theme_mod( 'dc_wa_number', '6285600061005' );
}

/**
 * Label tampil nomor WA — teks yang ditampilkan ke pengunjung.
 *
 * @return string
 */
function dc_get_wa_label() {
    return get_theme_mod( 'dc_wa_label', '0856-0006-1005' );
}

/**
 * URL WhatsApp lengkap dengan pesan pre-filled berdasarkan konteks.
 *
 * Konteks yang tersedia:
 *   'header', 'hero', 'pricing', 'partnership',
 *   'cta', 'contact', 'floating', 'about', 'faq', 'default'
 *
 * @param string $context  Kode konteks untuk memilih pesan default.
 * @param string $custom   Pesan kustom — override konteks jika diisi.
 * @return string
 */
function dc_get_wa_url( $context = 'default', $custom = '' ) {
    $number = dc_get_wa_number();

    if ( $custom ) {
        $message = $custom;
    } else {
        $messages = [
            'header'      => 'Halo Depo Cleanique! Saya ingin konsultasi mengenai produk dan kemitraan.',
            'hero'        => 'Halo Depo Cleanique! Saya ingin konsultasi kemitraan.',
            'pricing'     => 'Halo! Saya tertarik dengan paket kemitraan Depo Cleanique.',
            'partnership' => 'Halo! Saya ingin mendaftar sebagai mitra Depo Cleanique.',
            'cta'         => 'Halo Depo Cleanique! Saya siap bergabung sebagai mitra.',
            'contact'     => 'Halo Depo Cleanique! Saya ingin berkonsultasi.',
            'floating'    => 'Halo Depo Cleanique! Saya ingin bertanya mengenai produk dan kemitraan.',
            'footer'      => 'Halo Depo Cleanique! Saya ingin bertanya lebih lanjut.',
            'about'       => 'Halo Depo Cleanique! Saya ingin mengenal lebih jauh tentang peluang kemitraan.',
            'faq'         => 'Halo Depo Cleanique! Saya punya pertanyaan.',
            'default'     => 'Halo Depo Cleanique!',
        ];
        $message = isset( $messages[ $context ] ) ? $messages[ $context ] : $messages['default'];
    }

    return 'https://wa.me/' . $number . '?text=' . rawurlencode( $message );
}


/* ─── Kontak ─────────────────────────────────────────── */

/**
 * Email bisnis.
 *
 * @return string
 */
function dc_get_email() {
    return get_theme_mod( 'dc_email', 'hello@depocleanique.com' );
}

/**
 * Alamat lengkap dalam format plain text (bisa multiline dengan \n).
 *
 * @return string
 */
function dc_get_address() {
    return get_theme_mod(
        'dc_address',
        "Jongke Tengah No. 30 RT.01/RW.23\nMlati, Sleman\nYogyakarta 55285\nIndonesia"
    );
}

/**
 * Alamat dalam format HTML — baris baru dikonversi ke <br>.
 * Sudah di-escape dengan esc_html(), aman untuk langsung di-echo.
 *
 * @return string HTML
 */
function dc_get_address_html() {
    return nl2br( esc_html( dc_get_address() ) );
}

/**
 * Jam operasional bisnis.
 *
 * @return string
 */
function dc_get_business_hours() {
    return get_theme_mod( 'dc_business_hours', 'Senin – Sabtu, 08.00 – 21.00 WIB' );
}


/* ─── Media Sosial ───────────────────────────────────── */

/**
 * URL media sosial berdasarkan nama platform.
 *
 * Platform yang didukung: 'instagram', 'facebook', 'tiktok'
 * Mengembalikan '#' jika belum diisi di Customizer.
 *
 * @param string $platform
 * @return string URL
 */
function dc_get_social_url( $platform ) {
    return get_theme_mod( 'dc_social_' . $platform, '#' );
}
