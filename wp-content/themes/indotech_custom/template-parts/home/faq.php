<?php
/**
 * Home FAQ Section
 */

$whatsapp = indotech_opt( 'whatsapp', '6285600061005' );
$wa_num   = preg_replace( '/[^0-9]/', '', $whatsapp );
$wa_msg   = rawurlencode( 'Halo indotech.id, saya ingin bertanya mengenai produk/layanan Anda.' );
?>

<section class="faq-section section-padding" id="home-faq" style="background: var(--surface);">
    <div class="container">

        <div class="section-header--split reveal">
            <div>
                <span class="section-tag section-tag--dark">FAQ</span>
                <h2 class="section-title" style="margin-top:16px;">Pertanyaan yang<br>Sering Ditanyakan</h2>
            </div>
            <div class="sh-divider" aria-hidden="true"></div>
            <div class="sh-right">
                <p class="section-desc">Tidak menemukan jawaban yang Anda cari? Hubungi tim penjualan atau kemitraan kami langsung melalui WhatsApp.</p>
                <a href="https://wa.me/<?php echo esc_attr( $wa_num ); ?>?text=<?php echo $wa_msg; ?>"
                   class="btn btn-whatsapp" target="_blank" rel="noopener">
                    Tanya via WhatsApp
                </a>
            </div>
        </div>

        <div class="faq-list reveal">

            <details class="faq-item" id="faq-home-1">
                <summary class="faq-question">
                    Bagaimana cara memulai kemitraan dengan PT Indotech Berkah Abadi?
                    <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="6,9 12,15 18,9"/></svg>
                </summary>
                <div class="faq-answer">
                    <p>Anda bisa memulai dengan menavigasi ke halaman Kemitraan, mengisi formulir pendaftaran mitra, atau menghubungi tim representatif kami langsung melalui WhatsApp untuk konsultasi awal mengenai tipe kemitraan (Distributor, Agen, atau Reseller).</p>
                </div>
            </details>

            <details class="faq-item" id="faq-home-2">
                <summary class="faq-question">
                    Apakah semua produk dari berbagai brand memiliki legalitas Kemenkes dan sertifikasi Halal?
                    <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="6,9 12,15 18,9"/></svg>
                </summary>
                <div class="faq-answer">
                    <p>Ya. Seluruh formulasi produk kebersihan kami (di bawah naungan Cleanique Lab, Cleanique Mart, Depo Cleanique, Orchid Care, dan Malabeez) telah melalui pengujian laboratorium dan memiliki izin edar resmi dari Kementerian Kesehatan RI (Kemenkes) serta sertifikasi Halal resmi MUI.</p>
                </div>
            </details>

            <details class="faq-item" id="faq-home-3">
                <summary class="faq-question">
                    Apakah PT Indotech melayani pengiriman produk ke luar pulau Jawa?
                    <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="6,9 12,15 18,9"/></svg>
                </summary>
                <div class="faq-answer">
                    <p>Tentu saja. Kami bekerja sama dengan berbagai mitra logistik kargo darat, laut, dan udara tepercaya untuk menjamin pengiriman pasokan kimia pembersih dan peralatan kebersihan secara aman dan ekonomis ke seluruh wilayah Indonesia.</p>
                </div>
            </details>

            <details class="faq-item" id="faq-home-4">
                <summary class="faq-question">
                    Apa itu layanan maklon (Private Label) di Cleanique Lab?
                    <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="6,9 12,15 18,9"/></svg>
                </summary>
                <div class="faq-answer">
                    <p>Layanan maklon memungkinkan Anda memproduksi produk sabun, deterjen, dan bahan pembersih lainnya menggunakan brand Anda sendiri. Kami menangani seluruh siklus manufaktur mulai dari formulasi di laboratorium R&D, sertifikasi Halal/Kemenkes, hingga pengemasan produk akhir.</p>
                </div>
            </details>

            <details class="faq-item" id="faq-home-5">
                <summary class="faq-question">
                    Berapa lama proses verifikasi pengajuan pendaftaran kemitraan baru?
                    <svg class="faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="6,9 12,15 18,9"/></svg>
                </summary>
                <div class="faq-answer">
                    <p>Tim marketing B2B kami akan memproses dan memverifikasi data pendaftaran Anda dalam waktu maksimal 1×24 jam kerja setelah formulir kemitraan dikirimkan.</p>
                </div>
            </details>

        </div>
    </div>
</section>
