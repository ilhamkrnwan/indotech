<?php
/**
 * Why Us Section — "Mengapa Indotech?"
 *
 * Layout: dua kolom — kiri checklist teks, kanan kartu bernomor.
 * Tanpa emoji, tanpa ikon sistem — murni tipografi.
 */

$reasons = [
    'Produsen & distributor langsung — tanpa perantara',
    'Jaringan distribusi tersebar di 34 provinsi Indonesia',
    'Bersertifikat BPOM, Halal MUI & ISO 9001:2015',
    'Tim dukungan B2B responsif, 7 hari seminggu via WA',
    'Stok selalu tersedia, pengiriman cepat & aman',
    'Harga kompetitif dengan margin profit optimal mitra',
];
?>

<section class="why-us-section section-padding" id="mengapa-kami">
    <div class="container">
        <div class="why-us-grid">

            <!-- ── Kiri: Daftar alasan ──────────────────────── -->
            <div class="why-us-content">
                <div class="section-tag">Mengapa Indotech?</div>
                <h2 class="section-title">Partner Distribusi yang <em>Sudah Terbukti</em></h2>
                <p class="why-us-desc">
                    Sejak 2011, PT Indotech Berkah Abadi telah melayani lebih dari 500 mitra
                    bisnis di seluruh Indonesia dengan komitmen kualitas dan ketepatan layanan.
                </p>

                <ul class="why-list">
                    <?php foreach ( $reasons as $text ): ?>
                    <li class="why-item">
                        <span class="why-check" aria-hidden="true">&mdash;</span>
                        <span><?php echo esc_html( $text ); ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <div class="why-actions">
                    <a href="<?php echo esc_url( home_url('/tentang-kami') ); ?>" class="btn btn-primary">
                        Tentang PT Indotech &rarr;
                    </a>
                    <a href="<?php echo esc_url( home_url('/kemitraan') ); ?>" class="btn btn-outline">
                        Program Kemitraan
                    </a>
                </div>
            </div><!-- /why-us-content -->

            <div class="why-us-divider" aria-hidden="true"></div>

            <!-- ── Kanan: Kartu bernomor ────────────────────── -->
            <div class="why-us-visual">

                <div class="why-card">
                    <div class="why-card-num">01</div>
                    <div class="why-card-body">
                        <h4>Kualitas Terjamin</h4>
                        <p>Setiap produk melewati quality control ketat sebelum keluar dari pabrik. Kebijakan bebas cacat produksi.</p>
                    </div>
                </div>

                <div class="why-card why-card--highlighted">
                    <div class="why-card-num">02</div>
                    <div class="why-card-body">
                        <h4>Harga Paling Kompetitif</h4>
                        <p>Produsen langsung = harga terbaik. Margin profit optimal untuk mitra reseller kami.</p>
                    </div>
                </div>

                <div class="why-card">
                    <div class="why-card-num">03</div>
                    <div class="why-card-body">
                        <h4>Layanan Khusus</h4>
                        <p>Setiap mitra mendapat manajer akun khusus. Masalah apa pun direspons dalam 24 jam.</p>
                    </div>
                </div>

            </div><!-- /why-us-visual -->

        </div>
    </div>
</section>
