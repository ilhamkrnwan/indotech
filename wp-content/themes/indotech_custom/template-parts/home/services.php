<?php
$services = [
    [
        'icon'  => '<svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><polyline points="16,2 12,7 8,2"/></svg>',
        'title' => 'Distribusi Grosir',
        'desc'  => 'Suplai produk homecare, laundry, dan pewangi dalam jumlah besar dengan harga grosir kompetitif. Cocok untuk retailer, minimarket, toko kelontong, hingga distributor daerah.',
        'perks' => ['MOQ fleksibel mulai 1 karton', 'Harga grosir langsung pabrik', 'Pengiriman ke seluruh Indonesia'],
        'featured' => false,
    ],
    [
        'icon'  => '<svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9,12 11,14 15,10"/></svg>',
        'title' => 'Produk Bersertifikat',
        'desc'  => 'Seluruh produk kami telah mendapatkan sertifikasi BPOM, Halal MUI, dan standar ISO 9001:2015. Jaminan kualitas dan keamanan untuk bisnis Anda dan pelanggan akhir.',
        'perks' => ['Bersertifikat BPOM resmi', 'Halal MUI & ISO 9001', 'QC ketat di setiap batch'],
        'featured' => true,
    ],
    [
        'icon'  => '<svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
        'title' => 'Kemitraan B2B',
        'desc'  => 'Program distributor dan reseller resmi dengan keuntungan eksklusif: harga khusus, dukungan marketing material, pelatihan penjualan, dan dedicated account manager.',
        'perks' => ['Harga distributor eksklusif', 'Support materi marketing', 'Account manager khusus'],
        'featured' => false,
    ],
];
?>

<section class="services-section section-padding" id="layanan">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">Layanan Kami</div>
            <h2 class="section-title">Solusi B2B Lengkap dari Indotech</h2>
            <p class="section-desc">Dari grosir skala kecil hingga kemitraan distribusi nasional — kami siap mendukung pertumbuhan bisnis Anda.</p>
        </div>

        <div class="services-grid">
            <?php foreach ($services as $svc): ?>
            <div class="service-card <?php echo $svc['featured'] ? 'service-card--featured' : ''; ?>">
                <?php if ($svc['featured']): ?>
                <div class="service-badge">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
                    Unggulan
                </div>
                <?php endif; ?>
                <div class="service-icon"><?php echo $svc['icon']; ?></div>
                <h3 class="service-title"><?php echo esc_html($svc['title']); ?></h3>
                <p class="service-desc"><?php echo esc_html($svc['desc']); ?></p>
                <ul class="service-perks">
                    <?php foreach ($svc['perks'] as $perk): ?>
                    <li>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20,6 9,17 4,12"/></svg>
                        <?php echo esc_html($perk); ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <a href="<?php echo esc_url(home_url('/kontak')); ?>" class="service-cta">
                    Pelajari Lebih
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
