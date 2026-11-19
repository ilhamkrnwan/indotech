---
status: accepted
---

# Evolusi sistem desain arsitektural Indotech berbasis referensi Manufy

Kami mengadaptasi komposisi arsitektural referensi Manufy (kanvas grid vertikal putus-putus, blok solusi obsidian-navy dengan poster vertikal *overlapping*, etalase kisah mitra asimetris 3 kartu, CTA orbital, dan kartu footer putih dengan watermark arsitektural) ke identitas visual Indotech menggunakan Indotech Cobalt (`#144EE3`), Deep Obsidian-Navy (`#0B1220`), Signal Lime dari logo resmi (`#D9F99D` / `#A3E635`), dan tipografi display `Onest` lokal berpasangan dengan `Inter`.

## Considered Options

- **Minimalis teks-dominan sebelumnya**: terlalu steril, belum memuat video perkenalan, dan belum memvisualisasikan kapabilitas manufaktur serta R&D secara meyakinkan.
- **Adaptasi arsitektural Manufy dengan palet Indotech**: mempertahankan seluruh cakupan B2B Indotech sambil menghadirkan ritme editorial modern yang dapat diaudit di tingkat komponen.

## Consequences

Seluruh gaya visual baru diisolasikan ke kelas root `.indotech-company-home` beserta prefix `.ch-*` di `assets/css/company-home.css` agar halaman dalam (`produk`, `tentang-kami`, `kemitraan`, `blog`, `kontak`) tidak mengalami regresi sebelum fase rollout berikutnya.
