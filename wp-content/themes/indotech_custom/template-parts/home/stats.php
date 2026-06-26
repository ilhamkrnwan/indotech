<?php
$stats = [
    [
        'value' => '500+',
        'label' => 'Mitra B2B Aktif',
        'desc'  => 'Retailer & distributor se-Indonesia',
        'icon'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
    ],
    [
        'value' => '6',
        'label' => 'Brand Unggulan',
        'desc'  => 'Cleanique Academy · Cleanique Lab · Cleanique Mart · Depo Cleanique · Malabeez · Orchid Care',
        'icon'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>',
    ],
    [
        'value' => '13+',
        'label' => 'Tahun Berpengalaman',
        'desc'  => 'Berdiri sejak 2011',
        'icon'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>',
    ],
    [
        'value' => '1000+',
        'label' => 'Varian Produk',
        'desc'  => 'Homecare, laundry, pewangi & lainnya',
        'icon'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>',
    ],
];
?>

<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <?php foreach ($stats as $i => $stat): ?>
            <div class="stat-item">
                <div class="stat-icon-wrap"><?php echo $stat['icon']; ?></div>
                <div class="stat-value"><?php echo esc_html($stat['value']); ?></div>
                <div class="stat-label"><?php echo esc_html($stat['label']); ?></div>
                <div class="stat-desc"><?php echo esc_html($stat['desc']); ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
