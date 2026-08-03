<?php

namespace Database\Seeders;

use App\Models\LowonganKerja;
use Illuminate\Database\Seeder;

class LowonganKerjaSeeder extends Seeder
{
    /**
     * Contoh data lowongan pekerjaan untuk pengembangan.
     */
    public function run(): void
    {
        $lowongans = [
            [
                'judul' => 'Staf Administrasi Keuangan',
                'perusahaan' => 'PT Bangka Digital Indonesia',
                'posisi' => 'Staf Administrasi',
                'lokasi' => 'Pangkalpinang, Bangka Belitung',
                'tipe_pekerjaan' => 'full_time',
                'deskripsi' => "Kami membuka lowongan untuk posisi Staf Administrasi Keuangan dengan tanggung jawab:\n\n- Mengelola administrasi keuangan harian perusahaan\n- Melakukan input dan rekonsiliasi data transaksi\n- Menyusun laporan keuangan bulanan\n- Membantu proses penggajian karyawan\n- Berkoordinasi dengan bagian akuntansi dan pajak",
                'persyaratan' => "- Minimal D3/S1 Akuntansi, Manajemen, atau Ekonomi\n- Menguasai Microsoft Office terutama Excel\n- Teliti, jujur, dan mampu bekerja dalam tim\n- Pengalaman di bidang administrasi keuangan menjadi nilai tambah\n- Bersedia ditempatkan di Pangkalpinang",
                'gaji' => 'Rp 3.500.000 - Rp 4.500.000',
                'kuota' => 2,
                'batas_lamaran' => now()->addDays(30)->toDateString(),
                'link_pendaftaran' => 'https://example.com/daftar',
                'kontak' => 'hrd@bangkadigital.co.id',
                'status_aktif' => true,
            ],
            [
                'judul' => 'UI/UX Designer (Magang)',
                'perusahaan' => 'Startup Kuliner Bangka',
                'posisi' => 'UI/UX Designer',
                'lokasi' => 'Remote / Hybrid',
                'tipe_pekerjaan' => 'magang',
                'deskripsi' => "Kesempatan magang bagi mahasiswa desain untuk mengembangkan produk digital kami:\n\n- Merancang wireframe dan prototype aplikasi mobile\n- Membuat design system dan komponen UI\n- Berkolaborasi dengan tim produk dan developer\n- Melakukan riset pengguna sederhana\n- Durasi magang 3-6 bulan dengan sertifikat",
                'persyaratan' => "- Mahasiswa aktif D3/S1 Desain Komunikasi Visual, Informatika, atau relevan\n- Menguasai Figma atau tools desain sejenis\n- Memiliki portofolio (boleh tugas kuliah)\n- Kreatif dan up-to-date dengan tren desain\n- Komunikatif dan mau belajar",
                'gaji' => 'Uang saku Rp 1.000.000/bulan',
                'kuota' => 3,
                'batas_lamaran' => now()->addDays(14)->toDateString(),
                'link_pendaftaran' => 'https://example.com/magang',
                'kontak' => 'career@kulinerbangka.id',
                'status_aktif' => true,
            ],
            [
                'judul' => 'Admin Media Sosial',
                'perusahaan' => 'CV Kreatif Media Bangka',
                'posisi' => 'Admin Sosmed',
                'lokasi' => 'Pangkalpinang',
                'tipe_pekerjaan' => 'part_time',
                'deskripsi' => "Lowongan part-time untuk mengelola media sosial perusahaan:\n\n- Membuat konten harian untuk Instagram dan TikTok\n- Menjadwalkan postingan konten\n- Merespon komentar dan DM pelanggan\n- Membuat laporan performa konten mingguan\n- Bekerja 4 jam/hari (bisa remote)",
                'persyaratan' => "- Minimal SMA/SMK sederajat\n- Aktif menggunakan media sosial\n- Mampu membuat konten menarik (foto/video)\n- Kreatif dan memiliki gaya komunikasi yang baik\n- Bersedia bekerja part-time",
                'gaji' => 'Rp 1.500.000 - Rp 2.000.000/bulan',
                'kuota' => 1,
                'batas_lamaran' => now()->addDays(21)->toDateString(),
                'link_pendaftaran' => 'https://example.com/apply',
                'kontak' => '0812-3456-7890',
                'status_aktif' => true,
            ],
            [
                'judul' => 'Tenaga Ahli Perencanaan Wilayah',
                'perusahaan' => 'Pemerintah Provinsi Kep. Bangka Belitung',
                'posisi' => 'Konsultan Perencanaan',
                'lokasi' => 'Pangkalpinang',
                'tipe_pekerjaan' => 'kontrak',
                'deskripsi' => "Dibutuhkan tenaga ahli perencanaan wilayah untuk proyek kerjasama 1 tahun:\n\n- Menyusun dokumen perencanaan tata ruang\n- Melakukan analisis data spasial dan kependudukan\n- Menyiapkan materi rapat dan presentasi\n- Berkoordinasi dengan OPD terkait\n- Kontrak kerja 1 tahun dengan perpanjangan",
                'persyaratan' => "- S1 Teknik Perencanaan Wilayah dan Kota (PWK) atau Geografi\n- IPK minimal 3.00\n- Menguasai GIS/ArcGIS dan AutoCAD\n- Pengalaman proyek pemerintah menjadi nilai tambah\n- Mampu bekerja dalam tim dan di bawah tekanan",
                'gaji' => 'Rp 7.000.000 - Rp 9.000.000',
                'kuota' => 1,
                'batas_lamaran' => now()->addDays(10)->toDateString(),
                'link_pendaftaran' => 'https://example.com/register',
                'kontak' => 'bkppd@babelprov.go.id',
                'status_aktif' => true,
            ],
            [
                'judul' => 'Barista & Kasir',
                'perusahaan' => 'Kopi Senja UBB',
                'posisi' => 'Barista',
                'lokasi' => 'Balunijuk, Bangka',
                'tipe_pekerjaan' => 'part_time',
                'deskripsi' => "Kafe di sekitar kampus UBB membuka lowongan barista dan kasir:\n\n- Meracik dan menyajikan kopi serta minuman\n- Melayani pelanggan dengan ramah\n- Menjaga kebersihan area kerja\n- Melakukan kasir dan transaksi pembayaran\n- Cocok untuk mahasiswa (shift sore/malam)",
                'persyaratan' => "- Usia maksimal 25 tahun\n- Pengalaman barista menjadi nilai tambah\n- Ramah, jujur, dan bertanggung jawab\n- Bersedia bekerja shift\n- Mahasiswa UBB diprioritaskan",
                'gaji' => 'Rp 1.800.000 + bonus',
                'kuota' => 2,
                'batas_lamaran' => now()->addDays(7)->toDateString(),
                'link_pendaftaran' => 'https://example.com/kopi',
                'kontak' => 'kopisenja@gmail.com',
                'status_aktif' => true,
            ],
            [
                'judul' => 'Programmer Laravel',
                'perusahaan' => 'PT Teknologi Nusantara',
                'posisi' => 'Backend Developer',
                'lokasi' => 'Jakarta / Remote',
                'tipe_pekerjaan' => 'full_time',
                'deskripsi' => "Perusahaan teknologi membuka lowongan Backend Developer:\n\n- Mengembangkan API dan layanan backend\n- Merancang struktur database\n- Melakukan code review dan unit testing\n- Berkolaborasi dengan tim frontend\n- Bekerja penuh waktu (remote/hibrid)",
                'persyaratan' => "- S1 Ilmu Komputer/Informatika atau setara\n- Menguasai PHP Laravel minimal 2 tahun pengalaman\n- Memahami REST API, MySQL, dan Git\n- Familiar dengan Docker dan CI/CD (nilai tambah)\n- Mampu bekerja mandiri dan dalam tim",
                'gaji' => 'Rp 8.000.000 - Rp 12.000.000',
                'kuota' => 3,
                'batas_lamaran' => now()->addDays(45)->toDateString(),
                'link_pendaftaran' => 'https://example.com/laravel',
                'kontak' => 'recruitment@teknologinusantara.id',
                'status_aktif' => true,
            ],
        ];

        foreach ($lowongans as $lowongan) {
            LowonganKerja::create($lowongan);
        }
    }
}
