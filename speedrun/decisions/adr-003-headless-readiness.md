# ADR-003: Headless CMS Readiness Strategy

## Status
Approved

## Context
Di masa mendatang, data brand, produk, dan dokumen unduhan PT Indotech Berkah Abadi direncanakan akan dikonsumsi oleh website frontend terpisah (misalnya web e-commerce mandiri brand *Malabeez* menggunakan Next.js). Karena itu, WordPress harus dirancang sejak awal agar siap berfungsi sebagai Headless CMS.

## Decision
Kami memutuskan untuk mengimplementasikan kesiapan Headless CMS melalui langkah berikut:
1.  **Custom REST API Routes**: Mengaktifkan namespace custom `/wp-json/indotech/v1/` dengan endpoint terdedikasi untuk brand, produk, dan solusi aplikasi. Format output JSON distandarisasi secara ketat.
2.  **CORS & Security**: Menambahkan filter hook `allowed_http_origins` pada WordPress untuk membatasi origin domain eksternal yang diizinkan memanggil API.
3.  **Media Path Independence**: Merekomendasikan penyimpanan media library di-offload ke AWS S3 atau Cloudflare R2 sehingga aset gambar dan PDF menggunakan URL CDN absolut, terpisah dari instance domain WordPress `/wp-content/uploads/`.

## Consequences
*   **Kelebihan**: Integrasi dengan aplikasi mobile, frontend Next.js, atau ERP eksternal menjadi sangat mudah di masa depan.
*   **Kekurangan**: Memerlukan penanganan caching API tambahan (seperti Cloudflare Edge Caching atau Redis) agar request API yang tinggi tidak membebani server hosting WordPress.
