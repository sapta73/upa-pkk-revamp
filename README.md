<div align="center">
  <img src="public/img/UPA.%20PKK.png" alt="UPA PKK UBB" height="80" />
  <h1 align="center">UPA PKK UBB — Website Revamp</h1>
  <p align="center">
    <strong>Unit Penunjang Akademik Pengembangan Karir dan Kewirausahaan</strong>
    <br />
    Universitas Bangka Belitung
  </p>
  <p align="center">
    <img src="https://img.shields.io/badge/Laravel-13-FF2D20?style=flat-square&logo=laravel" alt="Laravel 13" />
    <img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=flat-square&logo=php" alt="PHP 8.3" />
    <img src="https://img.shields.io/badge/Filament-3.3-FBB040?style=flat-square&logo=filament" alt="Filament 3.3" />
    <img src="https://img.shields.io/badge/Livewire-3.8-FB70A9?style=flat-square&logo=livewire" alt="Livewire 3.8" />
    <img src="https://img.shields.io/badge/Tailwind-4-06B6D4?style=flat-square&logo=tailwindcss" alt="Tailwind 4" />
    <img src="https://img.shields.io/badge/MySQL-8-4479A1?style=flat-square&logo=mysql" alt="MySQL 8" />
    <img src="https://img.shields.io/badge/License-MIT-green?style=flat-square" alt="MIT License" />
  </p>
</div>

---

## 📋 Tentang Project

Revamp total website **UPA PKK UBB** dari CodeIgniter 4 ke **Laravel 13** modern stack. Website ini menyediakan layanan informasi, bimbingan konseling karir & kewirausahaan, serta pengelolaan data akademik untuk civitas akademika Universitas Bangka Belitung.

### ✨ Fitur Utama

| Fitur | Status |
|---|---|
| 🏠 **Beranda Modern** — Hero slider cinematic, scroll animations premium | ✅ Selesai |
| 🧭 **Navigasi Cerdas** — Sticky navbar, scroll shrink, active section spy | ✅ Selesai |
| 📋 **Bimbingan Konseling** — Booking online, pilih konselor, jadwal | ✅ Selesai |
| 👨‍🏫 **Manajemen Konselor** — CRUD via Filament admin panel | ✅ Selesai |
| 📅 **Manajemen Booking** — Approval, status, link meeting via Filament | ✅ Selesai |
| 🎨 **Animasi Scroll** — IntersectionObserver, stagger, parallax, ripple | ✅ Selesai |
| 🔐 **Autentikasi Multi-Role** — Mahasiswa, Konselor, Admin (Breeze) | ✅ Selesai |
| 📱 **Responsive** — Mobile-first, hamburger menu, touch-friendly | ✅ Selesai |
| 🎯 **Konselor Dashboard** — Dashboard khusus konselor | ⏳ WIP |
| ⭐ **Rating & Feedback** — Rating setelah sesi konseling | ⏳ WIP |
| 📧 **Notifikasi Email** — Konfirmasi booking otomatis | ⏳ WIP |

---

## 🚀 Tech Stack

| Teknologi | Versi | Fungsi |
|---|---|---|
| **Laravel** | ^13.8 | Framework utama PHP |
| **PHP** | ^8.3 | Runtime |
| **MySQL** | 8.x | Database |
| **Filament** | ^3.3 | Admin panel (CRUD generator) |
| **Livewire** | ^3.8 | Frontend interaktif (SPA-like) |
| **Alpine.js** | 3.x | Frontend interaktivitas ringan |
| **Tailwind CSS** | 4.x | Utility CSS framework |
| **Vite** | 8.x | Build tool frontend |
| **Laravel Breeze** | ^2.4 | Authentication scaffolding |

---

## 🏗️ Struktur Project

```
upa-pkk-revamp/
├── app/
│   ├── Filament/Resources/       # Admin CRUD (Konselor, Booking)
│   ├── Http/Controllers/         # Controllers (Auth, BK pages)
│   ├── Http/Middleware/          # PeriksaRole middleware
│   ├── Livewire/Mahasiswa/       # BookingForm, MyBooking
│   └── Models/                   # User model
├── Modules/
│   └── BimbinganKonseling/
│       ├── app/Models/           # Konselor, Jadwal, Booking, Rating
│       ├── app/Http/Controllers/ # KonselingController
│       └── database/migrations/  # 5 migration files BK
├── resources/
│   ├── views/
│   │   ├── bk/                   # BK landing, daftar konselor, profil
│   │   ├── layouts/              # Frontend layout, navbar, footer
│   │   └── livewire/mahasiswa/   # Booking form, my booking
│   └── js/
│       ├── app.js                # Alpine init
│       └── scroll-animations.js  # Scroll animation engine
├── routes/
│   ├── web.php                   # Public routes
│   ├── auth.php                  # Auth routes
│   └── mahasiswa.php             # Mahasiswa protected routes
├── docs/
│   └── BIMBINGAN-KONSELING.md    # Dokumentasi lengkap fitur BK
└── public/
    ├── images/                   # Slider images
    └── img/                      # Logos, icons
```

---

## ⚡ Instalasi

### Prerequisites

- PHP ^8.3
- Composer
- Node.js & npm
- MySQL 8.x

### Langkah Instalasi

```bash
# 1. Clone repository
git clone git@github.com:sapta73/upa-pkk-revamp.git
cd upa-pkk-revamp

# 2. Install PHP dependencies
composer install

# 3. Install frontend dependencies
npm install

# 4. Copy environment file
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Konfigurasi database di .env
# DB_DATABASE=upa_pkk_revamp
# DB_USERNAME=root
# DB_PASSWORD=

# 7. Jalankan migration
php artisan migrate
php artisan migrate --path=Modules/BimbinganKonseling/database/migrations

# 8. Build frontend assets
npm run build

# 9. Storage link
php artisan storage:link

# 10. Jalankan development server
php artisan serve
```

---

## 🔐 Akun Default

| Role | Email | Password |
|---|---|---|
| **Admin** | `admin@upa-pkk.ubb.ac.id` | `admin123` |
| **Mahasiswa** | (registrasi via web) | — |

---

## 🎨 Branding

Warna branding resmi UPA PKK UBB:

| Warna | Hex | Penggunaan |
|---|---|---|
| **Primary Yellow** | `#ffb600` | CTA buttons, badge aktif, aksen |
| **Secondary Yellow** | `#ffc009` | Gradasi, hover state |
| **Dark** | `#23282d` | Navbar, hero background |
| **Footer Dark** | `#303030` | Footer background |
| **Light BG** | `#f5f5f5` | Section alternatif |

---

## 📄 Lisensi

Project ini dikembangkan untuk **UPA PKK Universitas Bangka Belitung**.

MIT License — silakan dikembangkan lebih lanjut.

---

<div align="center">
  <sub>Built with ❤️ by the UPA PKK Team</sub>
  <br />
  <sub>© 2026 UPA PKK UBB</sub>
</div>
