<?php
/**
 * Section: Comparison Table
 * Perbandingan detail paket dari _landing-source.html.
 */

$comparison_columns = [
    [
        'key'   => 'starter',
        'name'  => 'Starter',
        'price' => 'Rp 15jt',
    ],
    [
        'key'         => 'king',
        'name'        => 'King ⭐',
        'price'       => 'Rp 27.5jt',
        'recommended' => true,
    ],
];

$comparison_rows = [
    [
        'feature' => 'Lisensi Seumur Hidup',
        'starter' => [ 'type' => 'check' ],
        'king'    => [ 'type' => 'check' ],
    ],
    [
        'feature' => 'Stok Awal Produk',
        'starter' => [ 'type' => 'text', 'label' => '200 Liter' ],
        'king'    => [ 'type' => 'text', 'label' => '600 Liter', 'strong' => true ],
    ],
    [
        'feature' => '3D Interior Design Depo',
        'starter' => [ 'type' => 'remove' ],
        'king'    => [ 'type' => 'check' ],
    ],
    [
        'feature' => 'SEO Landing Page Eksklusif',
        'starter' => [ 'type' => 'remove' ],
        'king'    => [ 'type' => 'check' ],
    ],
    [
        'feature' => 'Full AI Marketing Support',
        'starter' => [ 'type' => 'text', 'label' => 'Terbatas (1 bln)', 'muted' => true ],
        'king'    => [ 'type' => 'text', 'label' => 'Eksklusif (3 bln)', 'strong' => true ],
    ],
    [
        'feature' => 'Garansi Modal Kembali 100%',
        'starter' => [ 'type' => 'check' ],
        'king'    => [ 'type' => 'check' ],
    ],
];

$comparison_totals = [
    'starter' => [
        'price' => 'Rp 15 Juta',
    ],
    'king'    => [
        'price' => 'Rp 27.5 Juta',
    ],
];
?>

<section class="comparison-section">
    <div class="container mx-auto px-margin-mobile md:px-margin-desktop">
        <div class="comparison-heading">
            <div class="section-kicker">
                <span class="section-kicker-dot" aria-hidden="true"></span>
                <span>Bandingkan &amp; Pilih</span>
            </div>
            <h2>
                Perbandingan Detail Paket
            </h2>
            <p>
                Semua fitur transparan — tanpa biaya tersembunyi.
            </p>
        </div>

        <div class="comparison-scroll">
            <div class="comparison-card">
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th scope="col" class="comparison-feature-head">
                                <span>
                                    Fitur &amp; Layanan
                                </span>
                            </th>
                            <?php foreach ( $comparison_columns as $column ) : ?>
                                <?php $is_recommended = ! empty( $column['recommended'] ); ?>
                                <th
                                    scope="col"
                                    class="comparison-plan-head<?php echo $is_recommended ? ' is-featured' : ''; ?>"
                                >
                                    <?php if ( $is_recommended ) : ?>
                                        <div class="comparison-plan-accent" aria-hidden="true"></div>
                                    <?php endif; ?>
                                    <p class="comparison-plan-name">
                                        <?php echo esc_html( $column['name'] ); ?>
                                    </p>
                                    <p class="comparison-plan-price">
                                        <?php echo esc_html( $column['price'] ); ?>
                                    </p>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ( $comparison_rows as $index => $row ) : ?>
                            <tr class="<?php echo 1 === $index % 2 ? 'is-zebra' : ''; ?>">
                                <th scope="row" class="comparison-feature-cell">
                                    <?php echo esc_html( $row['feature'] ); ?>
                                </th>
                                <?php foreach ( $comparison_columns as $column ) : ?>
                                    <?php
                                    $column_key     = $column['key'];
                                    $cell           = $row[ $column_key ];
                                    $is_recommended = ! empty( $column['recommended'] );
                                    ?>
                                    <td class="comparison-cell<?php echo $is_recommended ? ' is-featured' : ''; ?>">
                                        <?php if ( 'check' === $cell['type'] ) : ?>
                                            <span class="material-symbols-outlined comparison-status is-check" aria-label="<?php esc_attr_e( 'Tersedia', 'depocleanique-custom' ); ?>">
                                                check_circle
                                            </span>
                                        <?php elseif ( 'remove' === $cell['type'] ) : ?>
                                            <span class="material-symbols-outlined comparison-status is-remove" aria-label="<?php esc_attr_e( 'Tidak tersedia', 'depocleanique-custom' ); ?>">
                                                remove_circle
                                            </span>
                                        <?php else : ?>
                                            <span class="comparison-value<?php echo ! empty( $cell['strong'] ) ? ' is-strong' : ''; ?><?php echo ! empty( $cell['muted'] ) ? ' is-muted' : ''; ?>">
                                                <?php echo esc_html( $cell['label'] ); ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                    <tfoot>
                        <tr class="comparison-total-row">
                            <th scope="row" class="comparison-total-label">
                                <span>
                                    Total Investasi
                                </span>
                            </th>
                            <?php foreach ( $comparison_columns as $column ) : ?>
                                <?php
                                $column_key     = $column['key'];
                                $is_recommended = ! empty( $column['recommended'] );
                                $total          = $comparison_totals[ $column_key ];
                                ?>
                                <td class="comparison-total-cell<?php echo $is_recommended ? ' is-featured' : ''; ?>">
                                    <p>
                                        <?php echo esc_html( $total['price'] ); ?>
                                    </p>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>
