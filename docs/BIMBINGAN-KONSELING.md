# 📘 Dokumentasi Fitur Bimbingan Konseling — UPA PKK UBB

> **Versi Dokumen:** 1.0  
> **Tanggal:** 25 Juli 2026  
> **Project:** Revamp Website UPA PKK UBB (Laravel 13)  
> **Penulis:** GitHub Copilot (DeepSeek V4 Flash)

---

## 1. PROJECT OVERVIEW

| Atribut | Nilai |
|---|---|
| **Nama Project** | Revamp Website UPA PKK UBB — *Unit Penunjang Akademik Pengembangan Karir dan Kewirausahaan Universitas Bangka Belitung* |
| **Tujuan Project** | Migrasi total dari CodeIgniter 4 ke Laravel 13 + Filament + Livewire + Tailwind CSS. Membangun website modern, responsif, dan interaktif untuk melayani civitas akademika UBB. |
| **Target User** | Mahasiswa UBB, Konselor, Admin UPA PKK, Publik umum |
| **Tujuan Fitur BK** | Menyediakan platform **booking konseling karir & kewirausahaan** secara online. Mahasiswa bisa memilih konselor, menjadwalkan sesi, mendapatkan konseling, dan memberi rating. |
| **Status Development** | 🟡 **70% selesai** — Backend inti (CRUD, booking, Livewire) sudah jalan. Frontend hero slider & navbar sudah modern. Yang kurang: konselor dashboard, rating component, notifikasi, role gate di Filament. |

---

## 2. TECH STACK

### Framework & Core

| Teknologi | Versi | Fungsi |
|---|---|---|
| **Laravel** | ^13.8 | Framework utama PHP |
| **PHP** | ^8.3 | Runtime |
| **MySQL** | 8.x | Database (`upa_pkk_revamp`) |
| **Filament** | ^3.3 | Admin panel (CRUD generator) |
| **Livewire** | ^3.8 | Frontend interaktif (SPA-like) |
| **Alpine.js** | 3.x | Frontend interaktivitas ringan |
| **Tailwind CSS** | 4.x | Utility CSS framework |
| **Vite** | 8.x | Build tool frontend |
| **Laravel Breeze** | ^2.4 | Authentication scaffolding |

### Dependencies Kunci (`composer.json`)

```json
"filament/filament": "^3.3",
"laravel/breeze": "^2.4",
"laravel/framework": "^13.8",
"livewire/livewire": "^3.8",
"livewire/volt": "^1.7.0",
"nwidart/laravel-modules": "*"
```

### Dependencies NPM

```json
"@alpinejs/collapse": "^3.14",
"@alpinejs/intersect": "^3.14",
"alpinejs": "^3.14"
```

### Database

- **DBMS:** MySQL
- **Nama Database:** `upa_pkk_revamp`
- **User:** `upa_pkk`
- **Password:** `UpaPkk2026!`
- **ORM:** Eloquent (Laravel default)
- **Migration Path:** `database/migrations/` + `Modules/BimbinganKonseling/database/migrations/`
  > ⚠️ Module migrations harus dijalankan manual: `php artisan migrate --path=Modules/BimbinganKonseling/database/migrations`

### Authentication

| Aspek | Detail |
|---|---|
| **Package** | Laravel Breeze (Blade stack) |
| **Role** | `mahasiswa`, `konselor`, `admin` — disimpan di kolom `users.role` (enum) |
| **Default Role** | `mahasiswa` (saat register) |
| **Middleware** | `PeriksaRole` — custom middleware, alias `role` |
| **Login Redirect** | `admin` → `/admin`, `konselor` → `/konselor/dashboard` (⚠️ rute belum ada), `mahasiswa` → `/mahasiswa/my-booking` |

### Module System

- **Package:** `nwidart/laravel-modules`
- **Module Aktif:** `Core` (terdaftar di `modules_statuses.json`)
- **Module BK:** `BimbinganKonseling` — **TIDAK** terdaftar di `modules_statuses.json`, ServiceProvider (`BkServiceProvider`) juga **TIDAK** terdaftar di mana pun
- **PSR-4 Autoload:** `"Modules\\BimbinganKonseling\\": "Modules/BimbinganKonseling/app/"` (via composer.json)

---

## 3. FOLDER STRUCTURE (BK-related)

```
upa-pkk-revamp/
├── app/
│   ├── Filament/
│   │   └── Resources/
│   │       ├── BkResource.php              # Filament CRUD Konselor
│   │       └── BookingResource.php          # Filament CRUD Booking
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Auth/
│   │   │       ├── AuthenticatedSessionController.php  # Login + role redirect
│   │   │       └── RegisteredUserController.php        # Register + field tambahan
│   │   └── Middleware/
│   │       └── PeriksaRole.php             # Middleware role check
│   ├── Livewire/
│   │   └── Mahasiswa/
│   │       ├── BookingForm.php             # Form booking (2 step)
│   │       └── MyBooking.php               # Daftar booking mahasiswa
│   ├── Models/
│   │   └── User.php                        # User model (role, nim, prodi, nomor_hp)
│   └── Providers/
│       ├── AppServiceProvider.php          # Register Livewire components
│       └── Filament/
│           └── AdminPanelProvider.php       # Filament admin config
├── Modules/
│   └── BimbinganKonseling/
│       ├── app/
│       │   ├── Http/
│       │   │   └── Controllers/
│       │   │       └── KonselingController.php    # Public BK pages
│       │   ├── Models/
│       │   │   ├── Konselor.php
│       │   │   ├── Jadwal.php
│       │   │   ├── Booking.php
│       │   │   └── Rating.php
│       │   └── Providers/
│       │       └── BkServiceProvider.php   # ⚠️ TIDAK TERDAFTAR
│       ├── database/
│       │   └── migrations/
│       │       ├── ..._create_konselors_table.php
│       │       ├── ..._create_jadwals_table.php
│       │       ├── ..._create_bookings_table.php
│       │       ├── ..._create_ratings_table.php
│       │       └── ..._add_user_id_to_bookings.php
│       ├── routes/
│       │   └── web.php                     # ⚠️ Duplikat, tidak dipakai
│       └── module.json
├── resources/
│   ├── views/
│   │   ├── bk/
│   │   │   ├── index.blade.php             # Landing page BK
│   │   │   ├── daftar-konselor.blade.php   # Daftar konselor
│   │   │   └── profil-konselor.blade.php   # Profil + jadwal konselor
│   │   ├── layouts/
│   │   │   ├── frontend.blade.php          # Layout utama
│   │   │   └── navigasi.blade.php          # Navbar (link BK ada)
│   │   └── livewire/
│   │       └── mahasiswa/
│   │           ├── booking-form.blade.php  # Form booking Livewire
│   │           └── my-booking.blade.php    # Daftar booking Livewire
│   └── js/
│       ├── app.js                          # Alpine.init + scroll animations
│       └── scroll-animations.js            # Engine animasi scroll
├── routes/
│   ├── web.php                             # Route utama (termasuk BK public)
│   ├── auth.php                            # Route auth
│   └── mahasiswa.php                       # Route mahasiswa (role-protected)
├── database/
│   └── migrations/
│       ├── ..._create_users_table.php
│       └── ..._add_role_to_users.php       # Add role, nim, prodi, nomor_hp
├── tailwind.config.js
└── vite.config.js
```

---

## 4. DATABASE DESIGN

### 4.1. Tabel `users` (Laravel default + extended)

| Kolom | Tipe | Constraint | Fungsi |
|---|---|---|---|
| `id` | bigint, auto | PK | ID user |
| `name` | string(255) | required | Nama lengkap |
| `email` | string(255) | unique, required | Email login |
| `email_verified_at` | timestamp | nullable | Verifikasi email |
| `password` | string(255) | required | Password (hashed) |
| `remember_token` | string(100) | nullable | Remember me |
| `role` | enum('mahasiswa','konselor','admin') | default 'mahasiswa' | Role user |
| `nim` | string(20) | unique, nullable | NIM mahasiswa |
| `prodi` | string(100) | nullable | Program studi |
| `nomor_hp` | string(15) | nullable | Nomor HP |
| `created_at` | timestamp | | |
| `updated_at` | timestamp | | |

### 4.2. Tabel `konselors`

| Kolom | Tipe | Constraint | Fungsi |
|---|---|---|---|
| `id` | bigint, auto | PK | ID konselor |
| `id_konselor` | string(255) | **unique** | Kode unik konselor |
| `nama` | string(255) | required | Nama konselor |
| `nip` | string(255) | unique, nullable | NIP (PNS) |
| `spesialisasi` | string(255) | required | Bidang keahlian |
| `bio` | text | nullable | Biografi |
| `foto` | string(255) | nullable | Path foto |
| `nomor_hp` | string(255) | nullable | Nomor HP |
| `email` | string(255) | nullable | Email |
| `status_aktif` | boolean | default true | Status aktif/tidak |
| `created_at` | timestamp | | |
| `updated_at` | timestamp | | |

### 4.3. Tabel `jadwals`

| Kolom | Tipe | Constraint | Fungsi |
|---|---|---|---|
| `id` | bigint, auto | PK | ID jadwal |
| `konselor_id` | bigint | **FK → konselors.id**, CASCADE | ID konselor |
| `hari` | enum('senin','selasa','rabu','kamis','jumat','sabtu') | required | Hari |
| `jam_mulai` | time | required | Jam mulai |
| `jam_selesai` | time | required | Jam selesai |
| `kuota` | integer | default 1 | Maks booking per sesi |
| `status_aktif` | boolean | default true | Aktif/tidak |
| `created_at` | timestamp | | |
| `updated_at` | timestamp | | |

### 4.4. Tabel `bookings`

| Kolom | Tipe | Constraint | Fungsi |
|---|---|---|---|
| `id` | bigint, auto | PK | ID booking |
| `kode_booking` | string(255) | **unique** | Format: `BK-YYYYMMDD-XXXXX` |
| `user_id` | bigint | **FK → users.id**, nullOnDelete, nullable | ID user (mahasiswa) |
| `konselor_id` | bigint | **FK → konselors.id**, CASCADE | ID konselor |
| `nama_mahasiswa` | string(255) | required | Nama mahasiswa |
| `nim` | string(255) | required | NIM mahasiswa |
| `prodi` | string(255) | required | Prodi |
| `nomor_hp` | string(255) | required | Nomor HP |
| `email` | string(255) | required | Email |
| `tanggal` | date | required | Tanggal sesi |
| `jam_sesi` | time | required | Jam sesi |
| `deskripsi_masalah` | text | nullable | Deskripsi masalah |
| `status` | enum('menunggu','disetujui','ditolak','selesai','dibatalkan') | default 'menunggu' | Status booking |
| `link_meeting` | string(255) | nullable | Link Zoom/Meet |
| `catatan_konselor` | text | nullable | Catatan konseling |
| `waktu_booking` | timestamp | useCurrent | Waktu booking dibuat |
| `created_at` | timestamp | | |
| `updated_at` | timestamp | | |

### 4.5. Tabel `ratings`

| Kolom | Tipe | Constraint | Fungsi |
|---|---|---|---|
| `id` | bigint, auto | PK | ID rating |
| `booking_id` | bigint | **FK → bookings.id**, CASCADE | ID booking |
| `konselor_id` | bigint | **FK → konselors.id**, CASCADE | ID konselor |
| `nim_mahasiswa` | string(255) | required | NIM pemberi rating |
| `rating` | tinyInteger, unsigned | required | Nilai 1-5 |
| `komentar` | text | nullable | Komentar |
| `created_at` | timestamp | | |
| `updated_at` | timestamp | | |

---

## 5. MODEL RELATIONSHIP

```
 ┌──────────┐       ┌───────────┐       ┌──────────┐
 │  User    │       │ Konselor  │       │ Jadwal   │
 ├──────────┤       ├───────────┤       ├──────────┤
 │ id (PK)  │       │ id (PK)   │       │ id (PK)  │
 │ role     │       │ id_konselor(UQ)│   │ konselor_id(FK)──┐
 └────┬─────┘       └─────┬─────┘       └──────────┘       │
      │                   │                                 │
      │ 1              1 *│                               * │
      │                   │                                 │
      │     ┌─────────────┴─────────────┐                   │
      │     │                           │                   │
      │     │                           │                   │
      │  ┌──▼────────┐           ┌──────▼───────┐           │
      │  │  Booking  │           │   Rating     │           │
      │  ├───────────┤           ├──────────────┤           │
      └──│ user_id (FK)          │ konselor_id(FK)          │
         │ konselor_id(FK)───────┘ booking_id(FK)───┐       │
         │ status                                   │       │
         └──────────┘                               │       │
                                                   │       │
                                                   └───────┘
```

### Relasi Lengkap

| Model | Relasi | Terhadap | Method |
|---|---|---|---|
| `User` | — | — | (tidak ada relasi explicit ke BK models) |
| `Konselor` | **hasMany** | `Jadwal` | `$this->hasMany(Jadwal::class)` |
| `Konselor` | **hasMany** | `Booking` | `$this->hasMany(Booking::class)` |
| `Konselor` | **hasMany** | `Rating` | `$this->hasMany(Rating::class)` |
| `Jadwal` | **belongsTo** | `Konselor` | `$this->belongsTo(Konselor::class)` |
| `Booking` | **belongsTo** | `Konselor` | `$this->belongsTo(Konselor::class)` |
| `Booking` | **hasOne** | `Rating` | `$this->hasOne(Rating::class)` |
| `Rating` | **belongsTo** | `Booking` | `$this->belongsTo(Booking::class)` |
| `Rating` | **belongsTo** | `Konselor` | `$this->belongsTo(Konselor::class)` |

---

## 6. USER FLOW (Mahasiswa)

```
                    ╔══════════════════════════════╗
                    ║   Mahasiswa buka website     ║
                    ║   /bimbingan-konseling       ║
                    ╚══════════════════════════════╝
                               │
                               ▼
              ┌──────────────────────────────────┐
              │  Lihat landing page BK            │
              │  - Hero banner                    │
              │  - Penjelasan fitur               │
              │  - 5 step alur konseling          │
              │  - Grid konselor tersedia         │
              └──────────────────────────────────┘
                               │
                    ┌──────────┴──────────┐
                    ▼                     ▼
        ╔═══════════════════╗   (Langsung dari hero)
        ║  Klik "Lihat      ║   klik konselor card
        ║  Konselor"        ║
        ╚═══════════════════╝
                    │                     │
                    ▼                     ▼
        ┌──────────────────────┐
        │  /bimbingan-konseling│
        │  /konselor           │
        │  Daftar semua        │
        │  konselor (card grid)│
        └──────────────────────┘
                    │
                    ▼
        ┌──────────────────────────────────────────┐
        │  /bimbingan-konseling/konselor/{id}      │
        │  Profil konselor + jadwal tersedia       │
        │  (tabel hari, jam, kuota)                │
        │                                          │
        │  ┌─ BUTUH LOGIN ───────────────────────┐ │
        │  │  "Booking Sekarang"                 │ │
        │  │  → cek auth                         │ │
        │  │  → belum login → redirect ke login  │ │
        │  │  → sudah login → /mahasiswa/booking │ │
        │  └─────────────────────────────────────┘ │
        └──────────────────────────────────────────┘
                    │
                    ▼
        ╔═══════════════════════════════════════╗
        ║  STEP 1: Pilih Konselor               ║
        ║  /mahasiswa/booking                   ║
        ║  (kalo dari profil: langsung ke step2)║
        ╚═══════════════════════════════════════╝
                    │
                    ▼
        ╔═══════════════════════════════════════╗
        ║  STEP 2: Form Booking                 ║
        ║  - Pilih jadwal (dari jadwal aktif)  ║
        ║  - Pilih tanggal (harus > hari ini)  ║
        ║  - Pilih jam sesi                     ║
        ║  - Isi deskripsi masalah (min 10 chr)║
        ║  - Klik "Booking"                     ║
        ╚═══════════════════════════════════════╝
                    │
                    ▼
        ╔═══════════════════════════════════════╗
        ║  VALIDASI                             ║
        ║  - selectedJadwal: required           ║
        ║  - tanggal: required, date, after:today║
        ║  - deskripsiMasalah: required, min:10 ║
        ╚═══════════════════════════════════════╝
                    │
                    ▼
        ╔═══════════════════════════════════════╗
        ║  BOOKING BERHASIL                      ║
        ║  - Kode booking: BK-20260725-XXXXX    ║
        ║  - Status: MENUNGGU                    ║
        ║  - Link: "Lihat My Booking"           ║
        ╚═══════════════════════════════════════╝
                    │
                    ▼
        ╔═══════════════════════════════════════╗
        ║  /mahasiswa/my-booking                ║
        ║  Tab "Aktif":                         ║
        ║  - Booking dengan status menunggu     ║
        ║    atau disetujui                      ║
        ║  - Tombol "Batalkan" (kalo menunggu)  ║
        ║  - Link "Join Meeting" (kalo disetujui)║
        ║                                       ║
        ║  Tab "Riwayat":                       ║
        ║  - Booking dengan status selesai/     ║
        ║    dibatalkan/ditolak                 ║
        ║  - Link "Beri Rating" (kalo selesai)  ║
        ╚═══════════════════════════════════════╝
                    │
                    ▼
        ╔═══════════════════════════════════════╗
        ║  SESI KONSELING (via link meeting)    ║
        ║  - Konselor setuju → link muncul      ║
        ║  - Mahasiswa join meeting             ║
        ║  - Sesi selesai                       ║
        ╚═══════════════════════════════════════╝
                    │
                    ▼
        ╔═══════════════════════════════════════╗
        ║  FEEDBACK / RATING                    ║
        ║  - Admin/konselor ubah status "selesai"║
        ║  - Mahasiswa lihat di tab Riwayat     ║
        ║  - Klik "Beri Rating"                 ║
        ║  - ⚠️ COMPONENT BELUM ADA             ║
        ╚═══════════════════════════════════════╝
```

---

## 7. ADMIN FLOW

```
                    ╔══════════════════════════════╗
                    ║   Admin login → /admin       ║
                    ╚══════════════════════════════╝
                               │
                    ┌──────────┴──────────┐
                    ▼                     ▼
        ┌─────────────────────┐  ┌──────────────────────┐
        │  /admin/bk          │  │  /admin/bookings     │
        │  CRUD Konselor      │  │  CRUD Booking        │
        │  - Lihat daftar     │  │  - Lihat daftar      │
        │  - Tambah konselor  │  │  - Ubah status:      │
        │  - Edit konselor    │  │    menunggu →        │
        │  - Hapus konselor   │  │    disetujui/ditolak │
        │  - Upload foto      │  │  - Tambah link_meeting│
        │  - Aktif/nonaktifkan│  │  - Tambah catatan    │
        └─────────────────────┘  │  - Filter by status  │
                    │            └──────────────────────┘
                    ▼                       │
        ┌──────────────────────┐            ▼
        │  /admin/bk/{id}/edit │  ╔═══════════════════════╗
        │  - Kelola jadwal     │  ║ Ubah status booking   ║
        │    (tapi lewat       │  ║ → Admin set link Zoom ║
        │    Filament, jadwal  │  ║ → Disetujui           ║
        │    belum ada form    │  ║ → Selesai             ║
        │    di Filament)      │  ╚═══════════════════════╝
        └──────────────────────┘
```

**⚠️ Catatan:**
- Filament belum punya gate/role check — semua user yang login bisa akses `/admin`
- `Jadwal` dan `Rating` belum punya Filament Resource → dikelola manual via DB
- Tidak ada halaman laporan/laporan export

---

## 8. KONSELOR FLOW

```
                    ╔══════════════════════════════╗
                    ║   Konselor login             ║
                    ║   → redirect /konselor/      ║
                    ║   dashboard                  ║
                    ║   ⚠️ RUTE BELUM ADA          ║
                    ╚══════════════════════════════╝
```

**⚠️ Flow konselor BELUM diimplementasikan sama sekali:**
- Tidak ada route `/konselor/dashboard`
- Tidak ada controller/component untuk konselor
- Tidak ada tampilan jadwal pribadi konselor
- Tidak ada approval flow dari sisi konselor
- Tidak ada catatan konseling dari konselor

---

## 9. HALAMAN

| Nama | Route | Fungsi | Component/Controller | Status |
|---|---|---|---|---|
| **Beranda** | `/` | Landing page utama | Blade `beranda.blade.php` | ✅ Selesai |
| **BK Landing** | `/bimbingan-konseling` | Landing page BK | `KonselingController::index` | ✅ Selesai |
| **Daftar Konselor** | `/bimbingan-konseling/konselor` | Grid semua konselor | `KonselingController::daftarKonselor` | ✅ Selesai |
| **Profil Konselor** | `/bimbingan-konseling/konselor/{id}` | Detail + jadwal | `KonselingController::profilKonselor` | ✅ Selesai |
| **Form Booking** | `/mahasiswa/booking/{id?}` | Booking 2-step | `BookingForm` (Livewire) | ✅ Selesai |
| **My Booking** | `/mahasiswa/my-booking` | Daftar booking user | `MyBooking` (Livewire) | ✅ Selesai |
| **Form Rating** | `/mahasiswa/rating/{id}` | Rating setelah selesai | ⚠️ **BELUM ADA** | ❌ Belum |
| **Login** | `/login` | Login form | Breeze | ✅ Selesai |
| **Register** | `/register` | Register form | Breeze + extended | ✅ Selesai |
| **Admin Konselor** | `/admin/bk` | CRUD konselor | `BkResource` (Filament) | ✅ Selesai |
| **Admin Booking** | `/admin/bookings` | CRUD booking | `BookingResource` (Filament) | ✅ Selesai |
| **Konselor Dashboard** | `/konselor/dashboard` | Dashboard konselor | ⚠️ **BELUM ADA** | ❌ Belum |

---

## 10. COMPONENT

### Livewire Components

| Component | Class | View | Fungsi | Status |
|---|---|---|---|---|
| `mahasiswa.booking-form` | `App\Livewire\Mahasiswa\BookingForm` | `livewire/mahasiswa/booking-form.blade.php` | 2-step booking | ✅ |
| `mahasiswa.my-booking` | `App\Livewire\Mahasiswa\MyBooking` | `livewire/mahasiswa/my-booking.blade.php` | Daftar booking + cancel | ✅ |
| `mahasiswa.rating-form` | ⚠️ Belum ada | ⚠️ Belum ada | Form rating | ❌ |

### Filament Resources

| Resource | Model | Navigation | Fungsi | Status |
|---|---|---|---|---|
| `BkResource` | `Konselor` | Bimbingan Konseling → Konselor | CRUD Konselor | ✅ |
| `BookingResource` | `Booking` | Bimbingan Konseling → Booking | CRUD Booking | ✅ |
| `JadwalResource` | ⚠️ Belum ada | — | CRUD Jadwal | ❌ |
| `RatingResource` | ⚠️ Belum ada | — | Lihat rating | ❌ |

### Blade Components & Views

| View | Fungsi | Status |
|---|---|---|
| `layouts.frontend` | Layout utama (navbar, main, footer) | ✅ |
| `layouts.navigasi` | Navbar modern | ✅ |
| `layouts.footer` | Footer | ✅ |
| `beranda` | Halaman depan | ✅ |
| `bk.index` | Landing BK | ✅ |
| `bk.daftar-konselor` | Grid konselor | ✅ |
| `bk.profil-konselor` | Detail konselor | ✅ |
| `livewire.mahasiswa.booking-form` | Form booking | ✅ |
| `livewire.mahasiswa.my-booking` | Daftar booking | ✅ |

---

## 11. VALIDATION

### Register (`RegisteredUserController`)

| Field | Rules |
|---|---|
| `name` | required, string, max:255 |
| `nim` | required, string, max:20, unique:users,nim |
| `email` | required, string, lowercase, email, max:255, unique:users |
| `prodi` | required, string, max:100 |
| `nomor_hp` | required, string, max:15 |
| `password` | required, confirmed, Password::defaults() |

### Booking Form (`BookingForm`)

| Field | Rules |
|---|---|
| `selectedJadwal` | required |
| `tanggal` | required, date, after:today |
| `deskripsiMasalah` | required, min:10 |

### My Booking Cancel

| Action | Check |
|---|---|
| `batalkan($id)` | `where('user_id', auth()->id())` — hanya booking milik sendiri |

### Filament Resource Validation

| Resource | Field | Rules |
|---|---|---|
| `BkResource` | `id_konselor` | required, text |
| `BkResource` | `nama` | required, text |
| `BkResource` | `spesialisasi` | required, text |
| `BkResource` | `status_aktif` | boolean (toggle) |
| `BookingResource` | `konselor_id` | required, select |
| `BookingResource` | `nama_mahasiswa` | required, text |
| `BookingResource` | `nim` | required, text |
| `BookingResource` | `prodi` | required, text |
| `BookingResource` | `nomor_hp` | required, text |
| `BookingResource` | `email` | required, email |
| `BookingResource` | `tanggal` | required, date |
| `BookingResource` | `jam_sesi` | required, time |
| `BookingResource` | `status` | required, select |

---

## 12. BUSINESS RULE

| Rule | Detail | Status |
|---|---|---|
| **Kode Booking** | Format: `BK-YYYYMMDD-XXXXX` (via PHP) | ✅ |
| **Default Role** | Semua registrasi → `mahasiswa` | ✅ |
| **Booking Flow** | 2-step: pilih konselor → isi form | ✅ |
| **Tanggal Booking** | Harus `after:today` (min H+1) | ✅ |
| **Status Default** | Booking baru → `menunggu` | ✅ |
| **Cancel** | Hanya booking dgn status `menunggu` yg bisa dibatalkan | ✅ |
| **Ownership** | Mahasiswa hanya bisa cancel booking milik sendiri | ✅ |
| **Aktif Konselor** | Hanya konselor dgn `status_aktif = true` yg tampil | ✅ |
| **Aktif Jadwal** | Hanya jadwal dgn `status_aktif = true` yg ditampilkan | ✅ |
| **Meeting Link** | Admin input manual via Filament | ✅ |
| **Rating** | ⚠️ Hanya tampil link "Beri Rating" — component belum ada | ❌ |
| **Kuota Jadwal** | `kuota` disimpan di DB tapi **tidak dicek** saat booking | ⚠️ |
| **Jadwal Bentrok** | Tidak ada validasi bentrok jadwal | ⚠️ |
| **Jam Operasional** | Tidak ada batasan jam operasional | ⚠️ |
| **Reschedule** | Tidak ada fitur reschedule | ❌ |
| **Konselor Dashboard** | Tidak ada dashboard untuk konselor | ❌ |
| **Role Gate Admin** | Filament bisa diakses semua user (tanpa gate) | ❌ |

---

## 13. UI FLOW

```
URL: /bimbingan-konseling
┌─────────────────────────────────────────────┐
│  HERO: Gradient bg + "Bimbingan Konseling" │
│  CTA: "Lihat Konselor"                      │
├─────────────────────────────────────────────┤
│  SECTION: "Apa itu Bimbingan Konseling?"   │
│  - Penjelasan fitur                         │
├─────────────────────────────────────────────┤
│  SECTION: 5 Langkah Mudah                   │
│  - Step icons vertikal/horizontal           │
├─────────────────────────────────────────────┤
│  SECTION: Konselor Tersedia                 │
│  - Card grid (foto, nama, spesialisasi)     │
│  - Masing-masing klik → detail             │
└─────────────────────────────────────────────┘

URL: /bimbingan-konseling/konselor
┌─────────────────────────────────────────────┐
│  Grid semua konselor aktif                  │
│  Card: avatar/initial, nama, spesialisasi   │
│  Tombol: "Pilih Jadwal"                     │
└─────────────────────────────────────────────┘

URL: /bimbingan-konseling/konselor/{id}
┌─────────────────────────────────────────────┐
│  Header: nama, spesialisasi, foto           │
│  Bio section                                │
│  Tabel jadwal (hari, jam, kuota)            │
│  SIDEBAR:                                   │
│  - Jika auth + mahasiswa: "Booking Sekarang"│
│  - Jika auth + bukan mahasiswa: notif       │
│  - Jika guest: "Login untuk booking"        │
└─────────────────────────────────────────────┘

URL: /mahasiswa/booking/{id?}
┌─────────────────────────────────────────────┐
│  (Jika tanpa id) STEP 1: Pilih Konselor     │
│  Grid konselor aktif -> klik -> STEP 2      │
├─────────────────────────────────────────────┤
│  (Jika dengan id) STEP 2:                   │
│  - Nama konselor (readonly)                 │
│  - Select jadwal                            │
│  - Input tanggal (date picker)              │
│  - Input jam_sesi (time picker)             │
│  - Textarea deskripsi_masalah               │
│  - Tombol "Booking"                         │
├─────────────────────────────────────────────┤
│  SUCCESS STATE:                             │
│  - Icon centang                             │
│  - "Booking Berhasil! Kode: BK-..."        │
│  - Link "Lihat My Booking"                  │
└─────────────────────────────────────────────┘

URL: /mahasiswa/my-booking
┌─────────────────────────────────────────────┐
│  TAB: [ Aktif ] [ Riwayat ]                 │
│                                             │
│  TAB AKTIF:                                 │
│  ┌─────────────────────────────────────┐   │
│  │  Border kiri (kuning=menunggu       │   │
│  │            /hijau=disetujui)        │   │
│  │  Status badge                        │   │
│  │  Konselor, tanggal, jam, kode        │   │
│  │  [Join Meeting] (jika disetujui)    │   │
│  │  [Batalkan] (jika menunggu)         │   │
│  └─────────────────────────────────────┘   │
│                                             │
│  TAB RIWAYAT:                               │
│  ┌─────────────────────────────────────┐   │
│  │  Border kiri (biru=selesai          │   │
│  │            /merah=ditolak/dibatalkan)│   │
│  │  Status badge                        │   │
│  │  Konselor, tanggal, jam, kode        │   │
│  │  [Beri Rating] (jika selesai)       │   │
│  └─────────────────────────────────────┘   │
└─────────────────────────────────────────────┘
```

---

## 14. API / ACTION

### Livewire Actions

| Component | Action | Trigger | Fungsi |
|---|---|---|---|
| `BookingForm` | `pilihKonselor($id)` | Klik card konselor (step 1) | Set konselor → lanjut step 2 |
| `BookingForm` | `booking()` | Klik tombol "Booking" | Validasi → create booking → success state |
| `MyBooking` | `batalkan($id)` | Klik tombol "Batalkan" | Update status → `dibatalkan` |

### Public Controller Actions

| Controller | Method | Route | Fungsi |
|---|---|---|---|
| `KonselingController` | `index()` | GET `/bimbingan-konseling` | Tampil landing + konselor |
| `KonselingController` | `daftarKonselor()` | GET `/bimbingan-konseling/konselor` | Tampil grid konselor |
| `KonselingController` | `profilKonselor($id)` | GET `/bimbingan-konseling/konselor/{id}` | Tampil detail + jadwal |

---

## 15. NOTIFICATION FLOW

| Tipe | Status | Keterangan |
|---|---|---|
| **Email Konfirmasi Booking** | ❌ Belum | Tidak ada Mailable untuk notifikasi booking |
| **Email Approval/Rejection** | ❌ Belum | Tidak ada notifikasi saat admin setujui/tolak |
| **Database Notification** | ❌ Belum | Tidak ada `database_notifications` table |
| **Toast/Alert Livewire** | ⚠️ Sebagian | Form booking punya error validation, tapi tidak ada flash message sukses via session |
| **Filament Notification** | ✅ Ada | Filament built-in notification untuk CRUD actions |

---

## 16. FILE YANG PALING PENTING

| Peringkat | File | Fungsi |
|---|---|---|
| 🥇 | `app/Livewire/Mahasiswa/BookingForm.php` | Logic utama booking — 2 step form, validasi, create |
| 🥇 | `app/Livewire/Mahasiswa/MyBooking.php` | Dashboard mahasiswa — tab aktif/riwayat, cancel |
| 🥇 | `Modules/BimbinganKonseling/app/Models/Booking.php` | Model Booking — status, relasi |
| 🥈 | `Modules/BimbinganKonseling/app/Http/Controllers/KonselingController.php` | Public pages BK |
| 🥈 | `app/Filament/Resources/BkResource.php` | Admin CRUD konselor |
| 🥈 | `app/Filament/Resources/BookingResource.php` | Admin CRUD booking |
| 🥈 | `routes/web.php` | Semua route public BK |
| 🥈 | `routes/mahasiswa.php` | Route protected mahasiswa |
| 🥉 | `app/Http/Middleware/PeriksaRole.php` | Middleware role check |
| 🥉 | `app/Http/Controllers/Auth/AuthenticatedSessionController.php` | Login + redirect role-based |
| 🥉 | `app/Providers/AppServiceProvider.php` | Register Livewire components |
| 🥉 | `resources/views/livewire/mahasiswa/booking-form.blade.php` | UI form booking |
| 🥉 | `resources/views/livewire/mahasiswa/my-booking.blade.php` | UI daftar booking |
| 📄 | `Modules/BimbinganKonseling/database/migrations/*.php` | Semua migration BK |
| 📄 | `resources/views/bk/index.blade.php` | Landing page BK |

---

## 17. YANG SUDAH SELESAI ✅

- [x] Database: 5 tabel BK (konselors, jadwals, bookings, ratings, + user_id migration)
- [x] Model: Konselor, Jadwal, Booking, Rating (lengkap dengan relasi)
- [x] Public routes: Landing BK, daftar konselor, profil konselor
- [x] Livewire BookingForm: 2-step booking flow
- [x] Livewire MyBooking: Tab aktif/riwayat, cancel booking
- [x] Filament BkResource: CRUD konselor
- [x] Filament BookingResource: CRUD booking dengan status management
- [x] Auth: Register with nim, prodi, nomor_hp; Login with role redirect
- [x] Middleware: PeriksaRole (alias `role`)
- [x] Frontend hero slider dengan swipe + stagger animasi
- [x] Navbar modern dengan scroll effect, dropdown, active state
- [x] Scroll animations engine (IntersectionObserver, progress bar, parallax, ripple)
- [x] Navbar active section spy

---

## 18. YANG BELUM SELESAI ❌

- [ ] **Rating Livewire Component** — `/mahasiswa/rating/{id}` — MyBooking blade sudah punya link "Beri Rating" tapi component-nya belum dibuat
- [ ] **Konselor Dashboard** — Route `/konselor/dashboard` belum ada, padahal navbar & login redirect sudah指向nya
- [ ] **Konselor Flow** — Approval jadwal, lihat booking sendiri, catatan konseling, ubah status
- [ ] **Role Gate Filament** — `/admin` bisa diakses semua user yang login (tanpa pengecekan role)
- [ ] **Kuota Jadwal** — Kolom `kuota` ada tapi tidak divalidasi saat booking
- [ ] **Cek Jadwal Bentrok** — Tidak ada validasi bentrok waktu/jadwal
- [ ] **Reschedule** — Tidak ada fitur reschedule booking
- [ ] **Email Notification** — Tidak ada Mailable untuk konfirmasi, approval, rejection
- [ ] **Database Notification** — Tidak ada sistem notifikasi internal
- [ ] **Filament JadwalResource** — Jadwal belum punya Filament CRUD (dikelola manual)
- [ ] **Filament RatingResource** — Rating belum punya Filament CRUD
- [ ] **Laporan/Ekspor** — Tidak ada fitur laporan atau ekspor data booking
- [ ] **BkServiceProvider** — Tidak terdaftar — module routes/views/migrations auto-load tidak berfungsi
- [ ] **`user_id` di fillable Booking** — Tidak ada di `$fillable`, di-set langsung (bypass mass-assignment)
- [ ] **`role`, `nim`, `prodi`, `nomor_hp` di fillable User** — Tidak ada di `$fillable`, di-set langsung

---

## 19. KNOWN ISSUE

| Issue | Severity | Detail |
|---|---|---|
| **Filament tanpa role gate** | 🔴 Tinggi | Siapa pun yang login bisa akses `/admin` — termasuk mahasiswa |
| **Module BK ServiceProvider tidak terdaftar** | 🟡 Sedang | Migration harus dijalankan manual, views di-copy ke `resources/views/bk/` |
| **`user_id` tidak di fillable** | 🟢 Rendah | Bypass mass-assignment, riskan error di masa depan |
| **Rating component belum ada** | 🟡 Sedang | Link di MyBooking mengarah ke route yang undefined |
| **Konselor dashboard 404** | 🟡 Sedang | Login redirect + navbar link mengarah ke route yang undefined |
| **Kuota tidak divalidasi** | 🟢 Rendah | Bisa booking melebihi kuota |
| **No email notification** | 🟢 Rendah | Mahasiswa tidak dapat notifikasi saat booking di-approve |

---

## 20. NEXT ROADMAP

| Prioritas | Task | Estimasi |
|---|---|---|
| 🥇 P1 | **Buat Rating Livewire Component** (`/mahasiswa/rating/{id}`) | 2-3 jam |
| 🥇 P1 | **Buat Konselor Dashboard** (`/konselor/dashboard`) | 4-6 jam |
| 🥇 P1 | **Tambah Role Gate di Filament** (`AdminPanelProvider`) | 30 menit |
| 🥈 P2 | **Validasi Kuota Jadwal** + cek bentrok | 2 jam |
| 🥈 P2 | **Tambah Filament JadwalResource & RatingResource** | 2 jam |
| 🥈 P2 | **Tambah Mailable (Email Notification)** | 3-4 jam |
| 🥈 P2 | **Database Notification** | 2 jam |
| 🥉 P3 | **Fitur Reschedule** | 3 jam |
| 🥉 P3 | **Laporan/Ekspor Booking (PDF/Excel)** | 4 jam |
| 🥉 P3 | **Daftarkan BkServiceProvider** + bersihkan duplikasi | 1 jam |
| 🧹 | **Rapihin fillable** di model Booking & User | 30 menit |

---

## 21. RINGKASAN

Fitur **Bimbingan Konseling** adalah fitur inti dari website UPA PKK UBB yang memungkinkan mahasiswa melakukan booking sesi konseling karir dan kewirausahaan secara online.

### Arsitektur
- **Module** `BimbinganKonseling` (nwidart) — tapi tidak terdaftar resmi
- **5 tabel**: `konselors`, `jadwals`, `bookings`, `ratings`, + tambahan `user_id` di bookings
- **4 model**: `Konselor`, `Jadwal`, `Booking`, `Rating`
- **3 role**: `mahasiswa`, `konselor`, `admin`
- **Middleware**: `PeriksaRole` (alias: `role`)
- **Auth**: Breeze dengan custom register fields (nim, prodi, nomor_hp)

### Frontend
- **Landing BK**: `/bimbingan-konseling` — hero, penjelasan, langkah, grid konselor
- **Daftar konselor**: `/bimbingan-konseling/konselor`
- **Profil konselor**: `/bimbingan-konseling/konselor/{id}` — detail + jadwal + booking CTA
- **Form booking**: `/mahasiswa/booking/{id?}` — Livewire 2-step (pilih konselor → isi form)
- **My booking**: `/mahasiswa/my-booking` — Livewire tab aktif/riwayat + cancel
- **Admin**: `/admin/bk` (Konselor CRUD), `/admin/bookings` (Booking CRUD) — Filament

### Status: 🟡 **70% selesai**
Backend inti dan frontend public sudah berfungsi. Yang kurang adalah **Konselor Dashboard**, **Rating Component**, **Role Gate**, **Notification**, dan **Validasi tambahan**.
