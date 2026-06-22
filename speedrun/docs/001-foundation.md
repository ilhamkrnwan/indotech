# 001: Foundation

## 1. Coding Standards
Proyek PT Indotech Berkah Abadi mengikuti panduan **WordPress Coding Standards (WPCS)**. Semua file PHP wajib:
*   Menggunakan penamaan file berformat kebab-case atau class-specific (misal: `class-api-helper.php`).
*   Menggunakan fungsi sanitasi bawaan saat menerima request (`sanitize_text_field`, `sanitize_email`, `absint`).
*   Menggunakan fungsi output escaping saat me-render data ke browser (`esc_html`, `esc_attr`, `esc_url`, `wp_kses_post`).
*   Menerapkan verifikasi keamanan dengan **WP Nonces** di semua request AJAX.

## 2. Inisialisasi Plugin Core (`indotech-core`)
Struktur berkas modular plugin di-load menggunakan autoloader Composer:
```json
{
    "name": "indotech/indotech-core",
    "description": "Core functionalities for PT Indotech Berkah Abadi",
    "type": "wordpress-plugin",
    "require": {
        "htmlburger/carbon-fields": "^3.6"
    },
    "autoload": {
        "psr-4": {
            "Indotech\\Core\\": "src/"
        }
    }
}
```

## 3. Konfigurasi `theme.json` Tema
Konfigurasi `theme.json` diletakkan di root tema `indotech_custom` untuk mematikan setelan Gutenberg standar yang tidak diinginkan dan membatasi palet warna:
```json
{
  "version": 2,
  "settings": {
    "color": {
      "palette": [
        { "slug": "cobalt", "color": "#0057FF", "name": "Electric Blue" },
        { "slug": "cobalt-dark", "color": "#0041CC", "name": "Electric Blue Dark" },
        { "slug": "ink", "color": "#0A0F1E", "name": "Ink Dark" },
        { "slug": "white", "color": "#FFFFFF", "name": "White" },
        { "slug": "surface", "color": "#F8F9FC", "name": "Light Surface" },
        { "slug": "border", "color": "#E4E8F0", "name": "Border Gray" }
      ],
      "custom": false,
      "customGradient": false
    },
    "typography": {
      "fontFamilies": [
        {
          "fontFamily": "'Space Grotesk', sans-serif",
          "name": "Space Grotesk",
          "slug": "space-grotesk"
        },
        {
          "fontFamily": "'Inter', sans-serif",
          "name": "Inter",
          "slug": "inter"
        }
      ],
      "customFontSize": false
    },
    "layout": {
      "contentSize": "1200px",
      "wideSize": "1400px"
    }
  }
}
```
Ini memaksa tim pembuat konten di Gutenberg menggunakan elemen visual yang presisi dan konsisten dengan Corporate Identity.
