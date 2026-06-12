<?php
/**
 * Section: FAQ
 * Accordion dari _landing-source.html.
 * Anchor: id="faq"
 */

$faqs = [
    [
        'question' => 'Bagaimana sistem lisensi bekerja?',
        'answer'   => 'Sistem lisensi kami bersifat sekali bayar (one-time fee) tanpa ada biaya royalti bulanan atau tahunan. Setelah bergabung, Anda berhak menggunakan merek Depo Cleanique dan mendapatkan pasokan produk eksklusif dari pabrik kami selamanya.',
    ],
    [
        'question' => 'Apakah produk sudah berizin Kemenkes?',
        'answer'   => 'Ya, seluruh lini produk Depo Cleanique telah memiliki izin edar resmi dari Kemenkes RI dan bersertifikat Halal. Kami menjamin standar kualitas laboratorium untuk setiap batch produksi.',
    ],
    [
        'question' => 'Apa itu dukungan AI Marketing?',
        'answer'   => 'AI Marketing adalah sistem automasi periklanan kami yang memetakan audiens potensial di sekitar radius depo Anda melalui Facebook, Instagram, dan Google Ads secara otomatis untuk menarik pelanggan baru setiap harinya.',
    ],
    [
        'question' => 'Bagaimana cara menjadi mitra?',
        'answer'   => 'Cukup dengan menghubungi tim konsultasi kami melalui WhatsApp, pilih paket investasi yang sesuai, lakukan survei lokasi (kami bantu secara digital), tanda tangan kontrak, dan depo Anda siap beroperasi dalam waktu maksimal 14 hari kerja.',
    ],
];
?>

<section class="faq-section" id="faq">
    <div class="container mx-auto px-margin-mobile md:px-margin-desktop">
        <div class="faq-heading">
            <div class="section-kicker">
                <span class="section-kicker-dot" aria-hidden="true"></span>
                <span>FAQ</span>
            </div>
            <h2>
                Pertanyaan Umum (FAQ)
            </h2>
            <p>
                Segala hal yang perlu Anda ketahui sebelum melangkah bersama Depo Cleanique.
            </p>
        </div>

        <div class="faq-list">
            <?php foreach ( $faqs as $index => $faq ) : ?>
                <?php
                $trigger_id = 'faq-trigger-' . $index;
                $panel_id   = 'faq-panel-' . $index;
                ?>
                <div class="dc-faq-item">
                    <button
                        id="<?php echo esc_attr( $trigger_id ); ?>"
                        type="button"
                        class="dc-faq-trigger"
                        aria-expanded="false"
                        aria-controls="<?php echo esc_attr( $panel_id ); ?>"
                    >
                        <span class="dc-faq-question-wrap">
                            <span class="dc-faq-number">
                                <?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?>
                            </span>
                            <span class="dc-faq-question">
                                <?php echo esc_html( $faq['question'] ); ?>
                            </span>
                        </span>
                        <span class="material-symbols-outlined dc-faq-icon" aria-hidden="true">
                            expand_more
                        </span>
                    </button>
                    <div
                        id="<?php echo esc_attr( $panel_id ); ?>"
                        class="dc-faq-panel"
                        role="region"
                        aria-labelledby="<?php echo esc_attr( $trigger_id ); ?>"
                        aria-hidden="true"
                    >
                        <div class="dc-faq-answer">
                            <?php echo esc_html( $faq['answer'] ); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
