# 006: Brand Module

Modul Brand menangani presentasi corporate brand yang berada di bawah holding PT Indotech Berkah Abadi.

## 1. Registrasi Metadata Brand (Carbon Fields)
Definisi field diletakkan pada core plugin `indotech-core` (`src/MetaFields.php`):
```php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make('post_meta', 'Brand Settings')
    ->where('post_type', '=', 'brand')
    ->add_fields([
        Field::make('text', 'brand_tagline', 'Tagline Brand')
            ->set_help_text('Contoh: Sabun & Pewangi Laundry Premium'),
        Field::make('color', 'brand_accent_color', 'Warna Aksen Brand')
            ->set_default_value('#0057FF'),
        Field::make('text', 'brand_website_url', 'URL Website Brand')
            ->set_help_text('Link situs mandiri brand jika terpisah dari holding'),
        Field::make('media_gallery', 'brand_gallery', 'Galeri Foto Brand')
    ]);
```

## 2. Rendering Detail Halaman Brand (`single-brand.php`)
Setiap brand memiliki halaman detail khusus yang menampilkan profil brand secara eksklusif. Untuk memperlihatkan katalog produk yang terikat ke brand tersebut:
```php
<?php
$brand_id = get_the_ID();
$brand_accent = carbon_get_post_meta($brand_id, 'brand_accent_color') ?: '#0057FF';
$brand_tagline = carbon_get_post_meta($brand_id, 'brand_tagline');

// Query produk terkait brand ini
$product_query = new WP_Query([
    'post_type'      => 'product',
    'posts_per_page' => 12,
    'meta_query'     => [
        [
            'key'     => 'product_brand',
            'value'   => $brand_id,
            'compare' => '='
        ]
    ]
]);
?>
<!-- Visual header dengan aksen warna brand -->
<header class="brand-hero" style="background-color: var(--ink); border-bottom: 3px solid <?php echo esc_attr($brand_accent); ?>">
    <div class="container">
        <h1><?php the_title(); ?></h1>
        <p class="tagline"><?php echo esc_html($brand_tagline); ?></p>
    </div>
</header>
```
Logika kueri di atas memastikan seluruh produk milik brand *Malabeez* otomatis terdaftar di bawah profil halaman *Malabeez*.
