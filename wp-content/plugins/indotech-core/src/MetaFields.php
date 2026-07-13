<?php
namespace Indotech\Core;

if (!defined('ABSPATH')) {
    exit;
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class MetaFields {
    /**
     * Initialize Carbon Fields registrations
     */
    public static function init() {
        add_action('carbon_fields_fields_registered', [self::class, 'register_meta_fields']);
    }

    /**
     * Register fields
     */
    public static function register_meta_fields() {
        // ── 1. Brand Meta Fields ──────────────────────────────────────────────────
        Container::make('post_meta', __('Brand Settings', 'indotech-core'))
            ->where('post_type', '=', 'brand')
            ->add_fields([
                Field::make('text', 'brand_tagline', __('Tagline Brand', 'indotech-core'))
                    ->set_help_text(__('Slogan promosi brand (misal: Bibit Sabun & Pewangi Laundry)', 'indotech-core')),
                Field::make('color', 'brand_accent_color', __('Warna Aksen Brand', 'indotech-core'))
                    ->set_default_value('#0057FF')
                    ->set_help_text(__('Warna tema khusus untuk brand ini', 'indotech-core')),
                Field::make('text', 'brand_website_url', __('URL Website Brand', 'indotech-core'))
                    ->set_help_text(__('Tautan ke website resmi brand jika ada', 'indotech-core')),
                Field::make('media_gallery', 'brand_gallery', __('Galeri Foto Brand', 'indotech-core'))
                    ->set_help_text(__('Galeri visual pendukung produk brand', 'indotech-core')),
            ]);

        // ── 2. Product Meta Fields ────────────────────────────────────────────────
        Container::make('post_meta', __('Product Settings', 'indotech-core'))
            ->where('post_type', '=', 'product')
            ->add_fields([
                Field::make('text', 'product_sku', __('SKU / Kode Produk', 'indotech-core'))
                    ->set_required(true)
                    ->set_help_text(__('Kode unik produk (misal: OC-DET-01)', 'indotech-core')),
                Field::make('association', 'product_brand', __('Pilih Brand', 'indotech-core'))
                    ->set_types([
                        [
                            'type'      => 'post',
                            'post_type' => 'brand',
                        ]
                    ])
                    ->set_max(1)
                    ->set_required(true)
                    ->set_help_text(__('Kaitkan produk ini dengan salah satu brand korporat', 'indotech-core')),
                Field::make('media_gallery', 'product_gallery', __('Galeri Foto Produk', 'indotech-core'))
                    ->set_help_text(__('Galeri foto pendukung produk (selain foto utama)', 'indotech-core')),
                Field::make('association', 'product_downloads', __('Dokumen Unduhan Terkait', 'indotech-core'))
                    ->set_types([
                        [
                            'type'      => 'post',
                            'post_type' => 'attachment',
                        ]
                    ])
                    ->set_help_text(__('Pilih file PDF (SDS/MSDS/Katalog) dari Media Library untuk produk ini', 'indotech-core')),
                Field::make('association', 'product_industries', __('Pilih Sektor Industri', 'indotech-core'))
                    ->set_types([
                        [
                            'type'      => 'post',
                            'post_type' => 'industry',
                        ]
                    ])
                    ->set_help_text(__('Kaitkan produk ini dengan satu atau lebih solusi industri B2B', 'indotech-core')),
                Field::make('complex', 'product_specifications', __('Spesifikasi Produk (Tabel Key-Value)', 'indotech-core'))
                    ->set_layout('tabbed-horizontal')
                    ->add_fields([
                        Field::make('text', 'spec_name', __('Nama Parameter', 'indotech-core'))
                            ->set_help_text(__('Misal: Nilai pH, Warna, Aroma, Ukuran Kemasan', 'indotech-core')),
                        Field::make('text', 'spec_value', __('Nilai Parameter', 'indotech-core'))
                            ->set_help_text(__('Misal: 7.0 (Netral), Biru Pekat, Lavender, 5 Liter', 'indotech-core')),
                    ]),
            ]);

        // ── 3. Industry Meta Fields ───────────────────────────────────────────────
        Container::make('post_meta', __('Industry Settings', 'indotech-core'))
            ->where('post_type', '=', 'industry')
            ->add_fields([
                Field::make('text', 'industry_icon', __('Nama Ikon SVG', 'indotech-core'))
                    ->set_help_text(__('Nama slug ikon untuk memuat visual di frontend (misal: hospital, hotel)', 'indotech-core')),
                Field::make('text', 'industry_tagline', __('Tagline Solusi Industri', 'indotech-core'))
                    ->set_help_text(__('Deskripsi ringkas solusi industri (misal: Solusi kebersihan berstandar klinis untuk rumah sakit)', 'indotech-core')),
            ]);

        // ── 4. Application Meta Fields ────────────────────────────────────────────
        Container::make('post_meta', __('Application Settings', 'indotech-core'))
            ->where('post_type', '=', 'application')
            ->add_fields([
                Field::make('text', 'app_tagline', __('Tagline Aplikasi Layanan', 'indotech-core'))
                    ->set_help_text(__('Slogan penargetan kata kunci (misal: Jasa pasokan detergen dan pengharum hotel skala besar)', 'indotech-core')),
                Field::make('association', 'app_related_products', __('Produk Rekomendasi Aplikasi', 'indotech-core'))
                    ->set_types([
                        [
                            'type'      => 'post',
                            'post_type' => 'product',
                        ]
                    ])
                    ->set_help_text(__('Pilih produk yang direkomendasikan untuk aplikasi layanan B2B ini', 'indotech-core')),
                Field::make('media_gallery', 'app_gallery', __('Galeri Foto Aplikasi', 'indotech-core'))
                    ->set_help_text(__('Galeri foto pendukung untuk aplikasi layanan ini', 'indotech-core')),
            ]);

        // ── 5. Media Library Attachment Meta Fields ───────────────────────────────
        Container::make('post_meta', __('Attachment Settings', 'indotech-core'))
            ->where('post_type', '=', 'attachment')
            ->add_fields([
                Field::make('checkbox', 'download_gate_active', __('Aktifkan Download Gate (Wajib Isi Form)', 'indotech-core'))
                    ->set_option_value('yes')
                    ->set_default_value('')
                    ->set_help_text(__('Mewajibkan user mengisi data diri sebelum mengunduh file ini', 'indotech-core')),
                Field::make('text', 'download_counter', __('Jumlah Unduhan (Counter)', 'indotech-core'))
                    ->set_default_value('0')
                    ->set_attributes(['type' => 'number', 'min' => 0])
                    ->set_help_text(__('Total hit download file ini', 'indotech-core')),
            ]);

        // ── 6. Global Site Settings Page ──────────────────────────────────────────
        Container::make('theme_options', __('Site Settings', 'indotech-core'))
            ->set_page_menu_title(__('Site Settings', 'indotech-core'))
            ->set_page_menu_position(50)
            ->add_fields([
                // Tab: Profil Perusahaan
                Field::make('text', 'company_name', __('Nama Perusahaan', 'indotech-core'))
                    ->set_default_value('PT Indotech Berkah Abadi'),
                Field::make('textarea', 'company_tagline', __('Tagline Korporat', 'indotech-core')),
                Field::make('file', 'company_profile_pdf', __('Company Profile PDF', 'indotech-core'))
                    ->set_type('pdf')
                    ->set_help_text(__('Upload file Company Profile resmi perusahaan', 'indotech-core')),

                // Tab: Informasi Kontak
                Field::make('text', 'company_whatsapp', __('WhatsApp Hotline', 'indotech-core'))
                    ->set_default_value('6285600061005')
                    ->set_help_text(__('Nomor WA dengan kode negara, tanpa spasi/simbol (misal: 6285600061005)', 'indotech-core')),
                Field::make('text', 'company_email', __('Email Resmi', 'indotech-core'))
                    ->set_default_value('indotechberkahabadi@gmail.com'),
                Field::make('text', 'company_phone', __('Telepon Kantor', 'indotech-core'))
                    ->set_default_value('+62 856-0006-1005'),
                Field::make('textarea', 'company_address', __('Alamat Pabrik & Kantor', 'indotech-core'))
                    ->set_default_value('Jongke Tengah No. 30, RT.01/RW.23, Sendangadi, Kec. Mlati, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55285'),
                Field::make('text', 'company_maps_url', __('Google Maps Embed URL / Koordinat', 'indotech-core')),

                // Tab: Sosial Media
                Field::make('text', 'social_linkedin', __('LinkedIn URL', 'indotech-core')),
                Field::make('text', 'social_instagram', __('Instagram URL', 'indotech-core')),
                Field::make('text', 'social_youtube', __('YouTube URL', 'indotech-core')),
            ]);
    }
}
