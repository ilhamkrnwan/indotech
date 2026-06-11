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
        <span class="material-symbols-outlined" style="font-size:24px;" aria-hidden="true">chat</span>
        <span class="hidden sm:inline"><?php esc_html_e( 'Hubungi Kami', 'depocleanique-custom' ); ?></span>
    </a>

</div>
