# 011: REST API Specifications

Untuk memastikan data produk holding PT Indotech Berkah Abadi dapat diakses lancar oleh frontend Next.js eksternal di masa depan, REST API custom dipersiapkan di dalam plugin `indotech-core` (`src/RestApi.php`).

## 1. Registrasi Custom Endpoints
Mendaftarkan custom route di hook `rest_api_init`:
```php
namespace Indotech\Core;

class RestApi {
    public function register_routes() {
        register_rest_route('indotech/v1', '/brands', [
            'methods'  => 'GET',
            'callback' => [$this, 'get_brands'],
            'permission_callback' => '__return_true'
        ]);

        register_rest_route('indotech/v1', '/products', [
            'methods'  => 'GET',
            'callback' => [$this, 'get_products'],
            'permission_callback' => '__return_true'
        ]);
    }
}
```

## 2. Struktur Payload Respon JSON
Setiap data produk dikirimkan dalam skema yang bersih dan konsisten:
```json
{
  "id": 142,
  "sku": "OC-DET-01",
  "name": "Orchid Care Detergen Liquid B2B",
  "slug": "orchid-care-detergen-liquid-b2b",
  "brand": {
    "id": 85,
    "name": "Orchid Care",
    "logo": "https://indotech.id/wp-content/uploads/brands/orchid-logo.png"
  },
  "specifications": [
    {
      "key": "pH",
      "value": "7.5"
    },
    {
      "key": "Bentuk",
      "value": "Cair"
    }
  ],
  "downloads": [
    {
      "title": "Safety Data Sheet Detergen Liquid",
      "url": "https://cdn.indotech.id/uploads/docs/sds-detergen.pdf",
      "gated": true
    }
  ]
}
```

## 3. Pengaturan CORS & Proteksi Input
*   **CORS Filters**: Hook disuntikkan pada headers WordPress REST API untuk mengizinkan request cross-origin hanya dari daftar whitelist domain brand terafiliasi.
*   **JWT Authentication**: Untuk request pengiriman inquiry/leads dari domain luar ke endpoint WordPress, JWT Token divalidasi terlebih dahulu demi keamanan data.
