<?php
/**
 * Template Part: Floating Tools
 * Tombol floating global — WhatsApp CTA + scroll to top.
 * Posisi fixed kanan bawah, z-index di bawah header (z-40), tidak menutupi konten utama.
 *
 * #scroll-top dikontrol oleh assets/js/main.js (show/hide saat scroll).
 * Nomor WA via helper — tidak hardcode.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<div class="dc-fab fixed bottom-5 right-4 sm:right-6 z-40 flex flex-col items-end gap-3"
     role="complementary"
     aria-label="<?php esc_attr_e( 'Tombol cepat', 'depocleanique-custom' ); ?>">

    <!-- Scroll to Top -->
    <button id="scroll-top"
            type="button"
            class="dc-fab-top"
            aria-label="<?php esc_attr_e( 'Kembali ke atas halaman', 'depocleanique-custom' ); ?>">
        <span class="material-symbols-outlined" style="font-size:22px;" aria-hidden="true">arrow_upward</span>
    </button>

    <!-- WhatsApp CTA -->
    <a href="<?php echo esc_url( dc_get_wa_url( 'floating' ) ); ?>"
       target="_blank"
       rel="noopener noreferrer"
       class="dc-fab-wa"
       aria-label="<?php esc_attr_e( 'Hubungi Depo Cleanique via WhatsApp', 'depocleanique-custom' ); ?>">
        <svg class="dc-fab-wa-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
            <path fill="currentColor" d="M16.03 3.2c-7.03 0-12.75 5.69-12.75 12.68 0 2.24.59 4.42 1.72 6.35L3.17 28.8l6.74-1.76a12.8 12.8 0 0 0 6.12 1.55c7.03 0 12.75-5.69 12.75-12.69S23.06 3.2 16.03 3.2Zm0 23.23c-1.93 0-3.82-.52-5.47-1.5l-.39-.23-4 1.05 1.07-3.89-.25-.4a10.45 10.45 0 0 1-1.6-5.58c0-5.81 4.77-10.53 10.64-10.53 5.86 0 10.63 4.72 10.63 10.53 0 5.82-4.77 10.55-10.63 10.55Zm5.84-7.9c-.32-.16-1.89-.93-2.18-1.03-.29-.11-.5-.16-.72.16-.21.32-.82 1.03-1.01 1.24-.19.21-.37.24-.69.08-.32-.16-1.35-.49-2.56-1.57-.95-.84-1.59-1.88-1.78-2.2-.19-.32-.02-.49.14-.65.14-.14.32-.37.48-.55.16-.19.21-.32.32-.53.11-.21.05-.4-.03-.56-.08-.16-.72-1.72-.98-2.35-.26-.62-.52-.53-.72-.54h-.61c-.21 0-.56.08-.85.4-.29.32-1.12 1.09-1.12 2.64s1.15 3.07 1.31 3.28c.16.21 2.26 3.43 5.47 4.81.76.33 1.36.52 1.82.67.77.24 1.46.21 2.01.13.61-.09 1.89-.77 2.15-1.51.27-.74.27-1.38.19-1.51-.08-.13-.29-.21-.61-.37Z" />
        </svg><span class="dc-fab-wa-text"><?php esc_html_e( 'Hubungi Kami', 'depocleanique-custom' ); ?></span>
    </a>

</div>
