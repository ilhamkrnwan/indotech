# 010: SEO Strategy & Schema Markup

Untuk memastikan aset jangka panjang SEO PT Indotech Berkah Abadi unggul di mesin pencarian, kami menerapkan integrasi schema terstruktur.

## 1. Schema Markup JSON-LD Dinamis
Pada halaman detail produk (`single-product.php`), schema JSON-LD disuntikkan secara otomatis ke tag `<head>` menggunakan data CPT dari plugin:
```html
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "<?php the_title(); ?>",
  "sku": "<?php echo esc_js($sku); ?>",
  "description": "<?php echo esc_js(wp_strip_all_tags(get_the_excerpt())); ?>",
  "offers": {
    "@type": "AggregateOffer",
    "priceCurrency": "IDR",
    "offers": [
      {
        "@type": "Offer",
        "url": "<?php the_permalink(); ?>"
      }
    ]
  },
  "manufacturer": {
    "@type": "Organization",
    "name": "PT Indotech Berkah Abadi",
    "url": "https://indotech.id"
  }
}
</script>
```

## 2. Struktur Kanonikal & Peta Situs (XML Sitemap)
*   **Canonical Mapping**: Mencegah duplikasi konten akibat URL parameter kueri filter AJAX (seperti `?brand=orchid-care`) dengan menyetel meta canonical absolut ke link utama posts (`/products/{slug}`).
*   **CPT Indexing**: Memastikan plugin SEO (RankMath / Yoast) dikonfigurasi untuk menyertakan Custom Post Types `brand`, `product`, `industry`, dan `application` ke dalam berkas `sitemap_index.xml` utama.

## 3. SEO Landing Page Solusi
Halaman `industry` dan `application` berperan sebagai pilar SEO landing page. Contoh kata kunci target:
*   `/applications/laundry-hotel/` menargetkan kata kunci *"supplier kimia laundry hotel"*
*   `/applications/cleaning-service/` menargetkan kata kunci *"distributor pembersih toilet gedung"*
Halaman-halaman ini memuat visual menarik, studi kasus singkat pemecahan masalah, rekomendasi daftar SKU produk Indotech, dan form inquiry langsung untuk konversi prospek B2B yang tinggi.
