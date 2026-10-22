# Design System | UPA PKK UBB

Dokumen ini menjadi acuan visual untuk halaman akun dan halaman lain yang disentuh pada Opsi C. Fokusnya konsistensi, keterbacaan, dan kesan institusi yang formal. Bukan tren visual semata.

## 1. Prinsip

1. Jelas sebelum cantik. Hierarki informasi harus terbaca tanpa effort.
2. Formal, tenang, dan profesional. Tidak norak, tidak seperti template AI.
3. Konsisten. Satu jenis tombol, satu jenis card, satu skala spacing.
4. Aksesibel. Kontras cukup, focus state jelas, bisa dipakai keyboard.
5. Ringan. Animasi secukupnya, tidak mengorbankan performa.
6. Kontekstual. Referensi visual harus relevan dengan website kampus dan unit penunjang akademik.

## 2. Token warna

| Token | Nilai | Pemakaian |
|---|---|---|
| Primary | `#ffb600` | Tombol utama, aksen, active state, highlight |
| Primary hover | `#e6a400` | Hover tombol utama |
| Primary soft | `#fff4d6` | Background badge, highlight ringan |
| Secondary | `#303030` | Footer, heading kuat, navbar dark |
| Dark | `#252525` | Teks utama alternatif, overlay |
| Accent | `#0052a5` | Tautan informasi, badge tertentu |
| Danger | `#c0343d` | Hapus akun, error kritis |
| Success | `#15803d` | Pesan sukses, status selesai |
| Warning | `#b45309` | Peringatan, status menunggu |
| Surface | `#ffffff` | Card, modal, form |
| Background | `#f9f9f9` | Latar halaman |
| Background alt | `#f3f4f6` | Section pemisah |
| Border | `#e5e7eb` | Garis card, input, divider |
| Text | `#1f2937` | Teks utama |
| Text muted | `#6b7280` | Helper, caption, metadata |

Aturan:

- Primary hanya untuk aksi utama. Jangan semua tombol kuning.
- Danger hanya untuk hapus akun dan error.
- Jangan memakai gradient di card atau form. Gradient hanya untuk hero publik.
- Jangan memakai glass effect di halaman akun.

## 3. Tipografi

Font: Plus Jakarta Sans.

| Level | Ukuran | Line height | Weight | Pemakaian |
|---|---|---|---|---|
| Display | 48px | 56px | 800 | Hero publik |
| H1 | 36px | 44px | 800 | Judul halaman |
| H2 | 30px | 38px | 700 | Judul section |
| H3 | 24px | 32px | 700 | Judul card |
| Body large | 18px | 28px | 400 | Paragraf utama |
| Body | 16px | 26px | 400 | Teks umum |
| Small | 14px | 22px | 500 | Label, helper, metadata |
| Caption | 12px | 18px | 600 | Badge, caption |

Aturan:

- Maksimal dua weight dalam satu card.
- Judul halaman memakai H1, bukan H2.
- Jangan memakai font selain Plus Jakarta Sans.
- Jangan memakai huruf kapital semua untuk paragraf.

## 4. Spacing

Skala: 4, 8, 12, 16, 24, 32, 48, 64, 80, 96, 120.

| Konteks | Nilai |
|---|---|
| Padding halaman mobile | 16px |
| Padding halaman tablet | 24px |
| Padding halaman desktop | 32px |
| Jarak antar field form | 20px |
| Padding card | 24px |
| Jarak antar section | 48px sampai 64px |
| Jarak antar card | 24px |
| Jarak judul ke isi | 8px sampai 12px |

## 5. Radius dan shadow

| Token | Nilai | Pemakaian |
|---|---|---|
| Radius sm | 8px | Badge, input kecil |
| Radius md | 12px | Input, tombol |
| Radius lg | 16px | Card, panel |
| Radius xl | 24px | Modal, hero card |
| Radius full | 9999px | Pill badge, avatar |

| Shadow | Nilai | Pemakaian |
|---|---|---|
| Shadow sm | `0 1px 2px rgba(0,0,0,0.05)` | Card default |
| Shadow md | `0 8px 24px rgba(0,0,0,0.08)` | Card hover, dropdown |
| Shadow lg | `0 20px 50px rgba(0,0,0,0.12)` | Modal |

Aturan: card default cukup border dan shadow sm. Jangan semua card punya shadow besar.

## 6. Layout

### Halaman publik

- Navbar fixed.
- Container maksimal 1280px.
- Section padding 80px sampai 120px.
- Footer dark.

### Halaman akun

- Navbar dan footer sama dengan halaman publik.
- Container maksimal 1120px.
- Grid desktop: sidebar 300px dan konten fleksibel, gap 32px.
- Grid tablet: sidebar 260px dan konten fleksibel.
- Mobile: satu kolom, sidebar menjadi ringkasan di atas.
- Jarak atas konten minimal 120px karena navbar fixed.

### Sidebar ringkasan akun

- Avatar inisial 64px, background primary soft, teks secondary.
- Nama, role badge, email.
- Untuk mahasiswa: NIM dan prodi.
- Untuk konselor: nomor HP.
- Tidak memakai foto profil jika belum ada unggahan.

## 7. Komponen

### Tombol

| Varian | Background | Teks | Border | Pemakaian |
|---|---|---|---|---|
| Primer | Primary | Secondary | Tidak ada | Simpan, kirim |
| Sekunder | Transparan | Secondary | Border | Batal, kembali |
| Outline | Putih | Secondary | Border | Aksi netral |
| Ghost | Transparan | Text muted | Tidak ada | Aksi kecil |
| Danger | Danger | Putih | Tidak ada | Hapus akun |
| Disabled | `#e5e7eb` | `#9ca3af` | Tidak ada | Tidak bisa diklik |

Ukuran: tinggi 40px, 44px, dan 48px. Font 14px weight 600. Radius 12px. Focus ring 2px primary dengan offset 2px.

### Input

- Tinggi 44px.
- Border 1px `#e5e7eb`.
- Radius 12px.
- Background putih.
- Label 14px weight 500, jarak 6px ke input.
- Helper 13px text muted.
- Error 13px danger.
- Focus: border primary dan ring primary 3px dengan opacity rendah.
- Disabled: background `#f9fafb`, teks muted.
- Placeholder: text muted dengan kontras cukup.

### Card

- Background putih.
- Border 1px `#e5e7eb`.
- Radius 16px.
- Padding 24px.
- Shadow sm.
- Judul H3.
- Deskripsi 14px text muted.
- Jarak judul ke isi 8px.
- Card tidak dipakai untuk semua section. Section utama boleh tanpa card.

### Badge role dan status

- Pill radius full.
- Font 12px weight 600.
- Padding 4px 10px.
- Mahasiswa: background `#e0f2fe`, teks `#0369a1`.
- Konselor: background primary soft, teks secondary.
- Admin: background `#ede9fe`, teks `#6d28d9`.
- Menunggu: warning soft.
- Disetujui: success soft.
- Ditolak: danger soft.

### Alert

- Success, error, warning, info.
- Border kiri 4px sesuai status.
- Background soft.
- Ikon inline SVG, bukan emoji.
- Font 14px.
- Muncul di atas form, bukan di dalam input.

### Modal

- Overlay `rgba(0,0,0,0.4)`.
- Panel putih, radius 24px, shadow lg, maksimal 480px.
- Judul H3.
- Deskripsi 14px.
- Tombol batal sekunder dan tombol konfirmasi danger.
- Fokus otomatis ke tombol batal.
- Tutup dengan Escape.

### Tab atau anchor

- Untuk halaman akun, gunakan anchor section, bukan tab tersembunyi.
- Menu samping berisi Data Diri, Keamanan, Hapus Akun.
- Active state memakai border kiri primary dan teks secondary.
- Mobile memakai select atau deretan tombol yang bisa discroll.

### Empty state

- Ikon inline SVG 32px.
- Judul H3.
- Deskripsi satu kalimat.
- Satu tombol aksi.

## 8. State dan interaksi

- Hover: perubahan warna atau shadow, durasi 200ms.
- Focus visible: ring primary, wajib untuk keyboard.
- Active: turun 1px atau shadow lebih kecil.
- Loading: spinner kecil di tombol, tombol disabled, teks tetap.
- Error: border danger dan pesan di bawah field.
- Success: alert di atas form dan fokus kembali ke judul section.
- Transisi memakai transform dan opacity. Hindari animasi width dan height.
- Hormati `prefers-reduced-motion`.

## 9. Aksesibilitas

- Setiap input punya label yang terhubung dengan `for` dan `id`.
- Pesan error terhubung dengan `aria-describedby`.
- Tombol ikon punya `aria-label`.
- Kontras teks minimal 4.5:1.
- Focus ring tidak boleh dihapus.
- Urutan tab mengikuti urutan visual.
- Modal memerangkap fokus dan mengembalikan fokus setelah ditutup.
- Jangan mengandalkan warna saja untuk status.

## 10. Responsif

| Breakpoint | Perilaku |
|---|---|
| 360px sampai 639px | Satu kolom, padding 16px, tombol full width |
| 640px sampai 1023px | Dua kolom untuk field tertentu, sidebar di atas |
| 1024px ke atas | Sidebar 300px dan konten fleksibel |
| 1280px ke atas | Container maksimal 1120px |

Aturan:

- Tidak ada horizontal scroll.
- Teks tidak lebih kecil dari 12px.
- Tombol minimal 44px tinggi di mobile.
- Navbar mobile memakai menu yang bisa ditutup.

## 11. Konten dan bahasa

- Semua teks Bahasa Indonesia.
- Nada formal, ringkas, tidak marketing.
- Gunakan "Anda" untuk halaman akun.
- Hindari istilah Inggris yang tidak perlu.
- Pesan error menjelaskan apa yang salah dan cara memperbaikinya.
- Tidak memakai emoji sebagai ikon.
- Tidak memakai em dash.

## 12. Larangan AI slop

- Tidak memakai layout template generik.
- Tidak memakai emoji sebagai ikon.
- Tidak memakai gradient dan glass berlebihan.
- Tidak memakai card untuk semua hal.
- Tidak memakai animasi berlebihan.
- Tidak memakai teks marketing kosong.
- Tidak memakai gambar stok yang tidak relevan.
- Tidak memakai dark mode palsu atau neon.

## 13. Wireframe halaman akun

Desktop:

- Navbar.
- Header halaman: judul "Akun Saya" dan deskripsi singkat.
- Grid dua kolom.
- Kiri: card ringkasan akun, menu anchor.
- Kanan: section Data Diri, section Keamanan, section Hapus Akun.
- Footer.

Mobile:

- Navbar.
- Card ringkasan akun.
- Menu anchor horizontal yang bisa discroll.
- Section Data Diri.
- Section Keamanan.
- Section Hapus Akun hanya untuk mahasiswa.
- Footer.

Section Data Diri:

- Nama.
- Email.
- NIM dan prodi untuk mahasiswa.
- Nomor HP untuk mahasiswa dan konselor.
- Tombol Simpan.

Section Keamanan:

- Password lama.
- Password baru.
- Konfirmasi password baru.
- Tombol Perbarui Password.
- Keterangan bahwa password baru minimal mengikuti aturan Laravel.

Section Hapus Akun:

- Hanya mahasiswa.
- Penjelasan dampak.
- Tombol Hapus Akun dengan warna danger.
- Modal konfirmasi password.

## 14. Catatan teknis

- Tailwind yang benar-benar dipakai saat ini adalah Tailwind v3 lewat PostCSS. Dependensi `@tailwindcss/vite` sudah dihapus agar tidak campur dengan v3.
- Jangan menambah library UI baru.
- Ikon memakai inline SVG atau Heroicons yang sudah tersedia.
- Layout akun memakai partial bersama: kepala, navigasi, kaki.
- `layouts.livewire` dan `layouts.akun` memakai partial yang sama.
- Semua komponen baru memakai nama variabel dan properti Bahasa Indonesia.
- Nama framework seperti `mount`, `render`, `edit`, `update`, dan `destroy` tetap apa adanya.
- Tidak ada komentar di file kode.

## 15. Checklist implementasi

- [ ] Token warna dan tipografi dipakai konsisten.
- [ ] Layout akun memakai navbar dan footer yang sama.
- [ ] Tombol memiliki varian yang jelas.
- [ ] Input memiliki label, helper, error, dan focus state.
- [ ] Modal hapus akun aksesibel.
- [ ] Halaman responsif di 360px, 768px, dan 1280px.
- [ ] Tidak ada emoji sebagai ikon.
- [ ] Tidak ada em dash.
- [ ] Tidak ada komentar baru.
- [ ] Tidak ada library baru.
