# 005: Frontend Layout & Design System

Desain web PT Indotech Berkah Abadi mengedepankan estetika premium modern: tipografi tebal, kontras tinggi, visual editor minimalis, dan transisi halus.

## 1. Design Tokens (CSS Custom Properties)
Sistem variabel warna dan layout global dideklarasikan di `:root` dalam file `assets/css/main.css`:
```css
:root {
  /* Palette */
  --cobalt:       #0057FF;
  --cobalt-dark:  #0041CC;
  --cobalt-pale:  #EEF3FF;
  --ink:          #0A0F1E;
  --white:        #FFFFFF;
  --surface:      #F8F9FC;
  --border:       #E4E8F0;

  /* Typography */
  --font-headings: 'Space Grotesk', sans-serif;
  --font-body:     'Inter', sans-serif;

  /* Spacing & Widths */
  --container-w:   1200px;
  --header-h:      72px;

  /* Transitions */
  --ease:          cubic-bezier(.4, 0, .2, 1);
  --transition:    0.22s var(--ease);
}
```

## 2. Struktur Grid & Kontainer
Semua pembungkus halaman menggunakan class `.container` dengan lebar maksimal 1200px dan padding kiri-kanan responsif:
```css
.container {
  max-width: var(--container-w);
  margin: 0 auto;
  padding: 0 40px;
}

@media (max-width: 768px) {
  .container {
    padding: 0 20px;
  }
}
```

## 3. Micro-Animations & Hover Effects
Untuk meningkatkan interaktivitas tanpa memperlambat loading page:
*   **Card Hover Expansion**: Seluruh kartu brand (`.brand-card`) dan kartu produk memiliki aksen border atas yang membesar dan pergeseran posisi Y setinggi `-4px` saat di-hover.
*   **Status Pulsing Dot**: Titik penanda keaktifan atau status menggunakan animasi keyframe pulsa untuk menarik perhatian visual user B2B secara halus.
*   **Smooth Scroll**: Efek scroll mulus yang dikendalikan murni oleh CSS (`html { scroll-behavior: smooth; }`).
*   **Header Backdrop Blur**: Efek glassmorphism pada header navigasi saat di-scroll menggunakan filter CSS `backdrop-filter: blur(24px)`.
