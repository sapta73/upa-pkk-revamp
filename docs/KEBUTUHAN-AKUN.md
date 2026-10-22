# Kebutuhan Halaman Akun | UPA PKK UBB

Dokumen ini menjadi acuan implementasi Opsi C. Semua keputusan di bawah sudah final kecuali bagian yang ditandai sebagai prasyarat eksternal.

## 1. Tujuan

Menyediakan satu halaman akun yang konsisten untuk mahasiswa, konselor, dan admin, dengan data yang sinkron, verifikasi email yang aktif, dan kebijakan hapus akun yang aman.

## 2. Ruang lingkup

Termasuk:

- Halaman `/profil`.
- Perubahan data diri sesuai role.
- Perubahan password.
- Hapus akun untuk mahasiswa.
- Verifikasi email penuh.
- Sinkronisasi data konselor antara `users` dan `konselors`.
- Penyesuaian navigasi desktop dan mobile.
- Pembersihan sisa scaffold Breeze dan Volt.
- Rename internal ke Bahasa Indonesia.

Tidak termasuk:

- Desain ulang halaman publik.
- Perubahan flow booking, jadwal, rating, dan pembayaran.
- Perubahan panel admin selain sinkronisasi data konselor.
- Fitur audit log, notifikasi database, dan ekspor laporan.

## 3. Aktor dan hak akses

| Aktor | Akses `/profil` | Ubah data diri | Ubah password | Hapus akun | Verifikasi email |
|---|---|---|---|---|---|
| Publik | Redirect ke login | Tidak | Tidak | Tidak | Tidak |
| Mahasiswa | Ya | Nama, email, NIM, prodi, nomor HP | Ya | Ya | Wajib untuk route mahasiswa |
| Konselor | Ya | Nama, email, nomor HP | Ya | Tidak | Wajib untuk route konselor |
| Admin | Ya | Nama, email | Ya | Tidak | Tidak wajib untuk panel admin |

## 4. Definisi istilah

- Akun: data login di tabel `users`.
- Profil: halaman `/profil`.
- Konselor: data publik di tabel `konselors` yang terhubung ke akun melalui `konselors.user_id`.
- Verifikasi email: proses memastikan alamat email akun valid.
- Hapus akun: menghapus baris `users`, bukan menghapus data historis booking atau konselor.

## 5. User story

### Mahasiswa

- Sebagai mahasiswa, saya bisa melihat dan mengubah nama, email, NIM, prodi, dan nomor HP.
- Sebagai mahasiswa, saya bisa mengubah password dengan memasukkan password lama.
- Sebagai mahasiswa, saya bisa menghapus akun saya sendiri setelah memasukkan password.
- Sebagai mahasiswa, saya bisa mengirim ulang email verifikasi jika belum terverifikasi.

### Konselor

- Sebagai konselor, saya bisa melihat dan mengubah nama, email, dan nomor HP.
- Sebagai konselor, saya tidak melihat field NIM dan prodi.
- Sebagai konselor, perubahan nama, email, dan nomor HP langsung memperbarui profil publik saya.
- Sebagai konselor, saya bisa mengubah password.
- Sebagai konselor, saya tidak bisa menghapus akun sendiri.

### Admin

- Sebagai admin, saya bisa melihat dan mengubah nama, email, dan password.
- Sebagai admin, saya tidak melihat field NIM, prodi, dan tombol hapus akun.
- Sebagai admin, saya bisa mengubah data konselor lewat Filament dan perubahan itu ikut memperbarui akun login konselor.

## 6. Alur halaman

### 6.1 Publik membuka `/profil`

1. Middleware `auth` mengarahkan ke `/login`.
2. Setelah login, user diarahkan ke `/dashboard`.
3. `/dashboard` meneruskan sesuai role.

### 6.2 Mahasiswa atau konselor belum verifikasi

1. User membuka route mahasiswa atau konselor.
2. Middleware `verified` mengarahkan ke `/verify-email`.
3. User bisa mengirim ulang email verifikasi.
4. User tetap bisa membuka `/profil` untuk mengganti email.
5. Setelah verifikasi, user diarahkan ke halaman tujuan semula.

### 6.3 Ubah data diri

1. User membuka `/profil`.
2. Sistem menampilkan field sesuai role.
3. User mengirim form.
4. Validasi berjalan di server.
5. Jika email berubah, `email_verified_at` direset.
6. Untuk konselor, data `nama`, `email`, dan `nomor_hp` disinkronkan ke `konselors`.
7. User kembali ke `/profil` dengan pesan sukses.

### 6.4 Ubah password

1. User mengisi password lama, password baru, dan konfirmasi.
2. Validasi memakai aturan password Laravel.
3. Password disimpan sebagai hash.
4. Session tetap aktif.
5. User kembali ke `/profil` dengan pesan sukses.

### 6.5 Hapus akun mahasiswa

1. Mahasiswa membuka section hapus akun.
2. Mahasiswa memasukkan password.
3. Sistem memvalidasi password.
4. User logout.
5. Baris `users` dihapus.
6. `bookings.user_id` menjadi null, data snapshot booking tetap ada.
7. Rating tetap ada.
8. User diarahkan ke halaman beranda.

## 7. Field per role

| Field | Mahasiswa | Konselor | Admin | Validasi |
|---|---|---|---|---|
| Nama | Wajib | Wajib | Wajib | required, string, max 255 |
| Email | Wajib | Wajib | Wajib | required, email, unik di `users`, lowercase |
| NIM | Wajib | Tidak tampil | Tidak tampil | required, string, max 20, unik di `users`, abaikan milik sendiri |
| Prodi | Wajib | Tidak tampil | Tidak tampil | required, harus dari daftar prodi |
| Nomor HP | Wajib | Wajib | Tidak tampil | required, string, max 15 |
| Password lama | Untuk ubah password | Untuk ubah password | Untuk ubah password | required, current_password |
| Password baru | Opsional | Opsional | Opsional | required_with password lama, confirmed, aturan password Laravel |
| Role | Tidak bisa diubah | Tidak bisa diubah | Tidak bisa diubah | tidak ada field |

Daftar prodi yang dipakai:

- Teknik Informatika
- Sistem Informasi
- Manajemen
- Akuntansi
- Hukum
- Teknik Sipil
- Teknik Elektro
- Agribisnis
- Biologi
- Fisika
- Matematika
- Kimia

Daftar ini harus disimpan di satu tempat, misalnya `config/upa.php`, lalu dipakai oleh form registrasi dan form profil.

## 8. Aturan bisnis

1. Role tidak boleh diubah dari halaman profil.
2. Email harus unik di tabel `users`.
3. NIM harus unik di tabel `users`, dengan pengecualian user yang sedang diedit.
4. Perubahan email mereset `email_verified_at`.
5. Konselor yang mengubah nama, email, atau nomor HP harus memperbarui baris `konselors` yang terhubung dalam satu transaksi database.
6. Admin yang mengubah nama, email, atau nomor HP konselor lewat Filament harus memperbarui baris `users` yang terhubung.
7. Hapus akun hanya tersedia untuk mahasiswa.
8. Admin dan konselor tidak melihat tombol hapus akun, dan endpoint hapus menolak role selain mahasiswa.
9. Hapus akun wajib konfirmasi password.
10. Data booking dan rating tidak dihapus saat akun mahasiswa dihapus.
11. Akun konselor yang dibuat atau ditautkan oleh admin langsung ditandai terverifikasi.
12. Akun admin yang sudah ada ditandai terverifikasi saat migrasi data.
13. Verifikasi email tidak diwajibkan untuk membuka `/profil`.
14. Verifikasi email diwajibkan untuk route mahasiswa dan konselor.
15. Panel admin Filament tidak memakai middleware `verified`.
16. Semua pesan validasi dan teks antarmuka memakai Bahasa Indonesia.
17. Tidak ada komentar baru di file kode.
18. Tidak ada karakter em dash di kode, dokumen, atau teks antarmuka.

## 9. Verifikasi email

### 9.1 Perubahan kode

- `App\Models\User` implements `Illuminate\Contracts\Auth\MustVerifyEmail`.
- Route `routes/mahasiswa.php` dan `routes/konselor.php` memakai middleware `auth` dan `verified`.
- `/profil` hanya memakai middleware `auth`.
- Registrasi diarahkan ke `verification.notice`, bukan langsung ke dashboard.
- `email_verified_at` direset saat email berubah.
- Pengguna bisa mengirim ulang email verifikasi dari halaman `/verify-email` dan dari `/profil`.

### 9.2 Prasyarat produksi

- `MAIL_MAILER=smtp`.
- Akun email cPanel, misalnya `noreply@upa-pkk.ubb.ac.id`.
- Host SMTP, port, enkripsi, username, dan password.
- SPF dan DKIM domain `upa-pkk.ubb.ac.id`.
- Alamat pengirim dan nama pengirim.
- Tes kirim email ke alamat nyata sebelum middleware `verified` diaktifkan di produksi.

### 9.3 Urutan rollout

1. Siapkan akun email dan konfigurasi SMTP.
2. Tes kirim email dari server produksi.
3. Tandai akun yang sudah ada sebagai terverifikasi.
4. Deploy kode verifikasi.
5. Aktifkan middleware `verified`.
6. Uji registrasi baru dan verifikasi email dari luar.

## 10. Kebijakan hapus akun

Keputusan: hanya mahasiswa yang boleh menghapus akun sendiri.

- Tombol hapus akun hanya muncul untuk role mahasiswa.
- Endpoint hapus memeriksa role dan menolak role lain dengan 403.
- Password wajib dikonfirmasi.
- Admin tidak bisa menghapus akunnya sendiri dari halaman profil.
- Konselor tidak bisa menghapus akunnya sendiri. Admin menonaktifkan konselor melalui `status_aktif` dan melepas tautan akun jika diperlukan.

## 11. Sinkronisasi data konselor

Sumber kebenaran:

- `users` untuk autentikasi dan kredensial.
- `konselors` untuk data yang tampil ke publik.

Aturan sinkronisasi:

- Perubahan dari halaman profil konselor: update `users` dan `konselors` dalam satu transaksi.
- Perubahan dari Filament: update `konselors` dan `users` dalam satu transaksi.
- Field yang disinkronkan: `nama`, `email`, `nomor_hp`.
- Password hanya ada di `users`.
- Jika email berubah, verifikasi direset dan konselor harus verifikasi ulang.

## 12. Navigasi

Desktop:

- Tombol dashboard sesuai role tetap ada.
- Tambah menu pengguna berisi nama dan dropdown dengan tautan `Profil Saya` dan `Keluar`.

Mobile:

- Tambah tautan `Profil Saya`.
- Tambah tautan dashboard untuk konselor, karena saat ini belum ada.
- Tombol `Keluar` tetap ada.

Semua tautan memakai `route('profil.edit')`.

## 13. Kebutuhan non-fungsional

- Responsif dari 360px sampai desktop.
- Aksesibel: label input, focus ring, kontras teks, navigasi keyboard.
- Tidak menambah library baru.
- Tidak mengubah flow bisnis di luar dokumen ini.
- Performa tetap ringan, tanpa animasi berlebihan.
- Mengikuti design system di `docs/DESIGN-SYSTEM.md`.

## 14. Acceptance criteria

- Guest membuka `/profil` diarahkan ke `/login`.
- Mahasiswa, konselor, dan admin bisa membuka `/profil`.
- Field yang tampil sesuai role.
- Mahasiswa bisa mengubah nama, email, NIM, prodi, dan nomor HP.
- Konselor bisa mengubah nama, email, dan nomor HP, dan data publik ikut berubah.
- Admin bisa mengubah nama dan email.
- Email atau NIM duplikat ditolak dengan pesan Bahasa Indonesia.
- Password bisa diubah dengan password lama yang benar.
- Mahasiswa bisa menghapus akun.
- Konselor dan admin tidak bisa menghapus akun.
- Mahasiswa dan konselor yang belum verifikasi diarahkan ke `/verify-email` saat membuka route terlindungi.
- Email verifikasi terkirim lewat SMTP.
- Email berubah, status verifikasi reset.
- Akun konselor buatan admin langsung terverifikasi.
- Semua tes lulus.

## 15. Rencana tes

- Guest membuka `/profil`.
- Setiap role membuka `/profil`.
- Update data per role.
- Validasi NIM duplikat, email duplikat, prodi tidak valid.
- Update password dengan password lama benar dan salah.
- Hapus akun mahasiswa berhasil.
- Hapus akun konselor dan admin ditolak.
- Unverified user ditolak dari route mahasiswa dan konselor.
- Verified user bisa mengakses.
- Registrasi mengirim notifikasi verifikasi.
- Verifikasi email lewat tautan.
- Ganti email mereset verifikasi.
- Sinkronisasi konselor dari profil.
- Sinkronisasi konselor dari Filament.
- Navbar menampilkan tautan profil untuk semua role.

## 16. Rename wajib

- `app/Http/Controllers/ProfileController.php` menjadi `app/Http/Controllers/ProfilController.php`.
- `app/Http/Requests/ProfileUpdateRequest.php` menjadi `app/Http/Requests/PerbaruiProfilRequest.php`.
- `resources/views/profile/` menjadi `resources/views/profil/`.
- `resources/views/profil/edit.blade.php` menjadi halaman utama.
- Partial menjadi `data-diri.blade.php`, `kata-sandi.blade.php`, dan `hapus-akun.blade.php`.
- `tests/Feature/ProfileTest.php` menjadi `tests/Feature/TesProfilTest.php`.
- Route path `/profil`.
- Route name `profil.edit`, `profil.update`, `profil.destroy`.
- Method controller tetap `edit`, `update`, dan `destroy` karena mengikuti konvensi Laravel.
- `/profile` lama dihapus tanpa redirect.

## 17. Prasyarat eksternal

- Kredensial SMTP cPanel.
- Alamat email pengirim.
- Konfirmasi SPF dan DKIM.
- Konfirmasi bahwa akun admin dan user lama ditandai terverifikasi saat deploy.

## 18. Status implementasi

- Opsi C sudah diterapkan dan deploy pada 21 Oktober 2026.
- Halaman `/profil` live dengan layout custom.
- Hapus akun hanya untuk mahasiswa.
- Sinkronisasi data konselor berjalan dua arah antara `users` dan `konselors`.
- Akun konselor buatan admin otomatis terverifikasi.
- Verifikasi email sudah ada di kode, tetapi `UPA_VERIFIKASI_EMAIL=false` di prod sampai SMTP dikonfigurasi.
- Seluruh 39 tes lulus.
- Backup kode server sebelum deploy: `backup-akun-20261022`.
- Langkah terakhir: konfigurasi SMTP, set `UPA_VERIFIKASI_EMAIL=true`, jalankan `config:clear`, lalu tes registrasi dan verifikasi email.
