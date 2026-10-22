@extends('layouts.frontend')

@section('title', $kegiatan->judul . ' | UPA PKK UBB')

@section('content')
@php
    $judulJenis = $kegiatan->jenis === 'workshop' ? 'Workshop' : 'Seminar';
    $sisaKuota = $kegiatan->sisa_kuota;
@endphp

<section class="relative overflow-hidden bg-gradient-to-br from-[#23282d] via-[#2c2c2c] to-[#23282d] py-20 lg:py-24">
    <div class="absolute w-[250px] h-[250px] bg-[#ffb600]/10 rounded-full blur-[100px] top-[-50px] right-[-50px]"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <a href="{{ route('kegiatan.index', $kegiatan->jenis) }}" class="inline-flex items-center gap-2 text-white/60 hover:text-white mb-6 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
            <span class="text-sm">Kembali ke {{ $judulJenis }}</span>
        </a>
        <div class="flex flex-wrap items-center gap-2 mb-4">
            <span class="px-3 py-1 rounded-full bg-white/10 border border-white/20 text-xs font-bold text-amber-300 uppercase tracking-wider">{{ $judulJenis }}</span>
            @if($kegiatan->wajib)
                <span class="px-3 py-1 rounded-full bg-red-500/20 border border-red-300/30 text-xs font-bold text-red-200 uppercase tracking-wider">Wajib Diikuti</span>
            @endif
        </div>
        <h1 class="text-3xl lg:text-5xl font-black text-white tracking-tight max-w-4xl">{{ $kegiatan->judul }}</h1>
        <div class="flex flex-wrap gap-x-6 gap-y-2 mt-5 text-white/70 text-sm">
            <span>{{ $kegiatan->tanggal_mulai->translatedFormat('d F Y') }}@if($kegiatan->tanggal_selesai) - {{ $kegiatan->tanggal_selesai->translatedFormat('d F Y') }}@endif</span>
            @if($kegiatan->jam_mulai)<span>{{ substr($kegiatan->jam_mulai, 0, 5) }}@if($kegiatan->jam_selesai) - {{ substr($kegiatan->jam_selesai, 0, 5) }}@endif WIB</span>@endif
            @if($kegiatan->lokasi)<span>{{ $kegiatan->lokasi }}</span>@endif
        </div>
    </div>
</section>

<section class="py-12 lg:py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        @if(session('sukses'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('sukses') }}</div>
        @endif
        @if(session('gagal'))
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('gagal') }}</div>
        @endif

        <div class="grid lg:grid-cols-[minmax(0,1fr)_380px] gap-8 items-start">
            <div class="space-y-6">
                @if($kegiatan->gambar)
                    <div class="rounded-2xl overflow-hidden border border-gray-100 bg-white">
                        <img src="{{ asset('storage/' . $kegiatan->gambar) }}" alt="{{ $kegiatan->judul }}" class="w-full max-h-[420px] object-cover">
                    </div>
                @endif

                <div class="bg-white rounded-2xl border border-gray-100 p-6 lg:p-8 shadow-sm">
                    <h2 class="text-xl font-bold text-[#252525] mb-4">Deskripsi Kegiatan</h2>
                    <div class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $kegiatan->deskripsi }}</div>
                </div>

                @if($kegiatan->harga > 0)
                    <div class="bg-white rounded-2xl border border-gray-100 p-6 lg:p-8 shadow-sm">
                        <h2 class="text-xl font-bold text-[#252525] mb-3">Informasi Pembayaran</h2>
                        <p class="text-sm text-gray-500 mb-4">Biaya kegiatan: <span class="font-bold text-[#b45309]">{{ $kegiatan->label_harga }}</span></p>
                        @if($kegiatan->instruksi_bayar)
                            <div class="text-sm text-gray-600 leading-relaxed whitespace-pre-line bg-gray-50 border border-gray-100 rounded-xl p-4">{{ $kegiatan->instruksi_bayar }}</div>
                        @else
                            <p class="text-sm text-gray-500">Hubungi admin UPA PKK untuk instruksi pembayaran.</p>
                        @endif
                    </div>
                @endif
            </div>

            <aside class="lg:sticky lg:top-28">
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-[#252525]">Pendaftaran</h2>
                    <div class="mt-3 space-y-2 text-sm text-gray-600">
                        <div class="flex justify-between"><span>Biaya</span><span class="font-semibold">{{ $kegiatan->label_harga }}</span></div>
                        <div class="flex justify-between"><span>Pendaftar</span><span class="font-semibold">{{ $jumlahPendaftar }} orang</span></div>
                        <div class="flex justify-between"><span>Kuota</span><span class="font-semibold">{{ $sisaKuota === null ? 'Tidak terbatas' : $sisaKuota . ' tersisa' }}</span></div>
                    </div>

                    <div class="mt-5 pt-5 border-t border-gray-100">
                        @auth
                            @if(in_array(auth()->user()->role, ['mahasiswa', 'dosen', 'tendik']))
                                @if($pendaftaran)
                                    <div class="space-y-3">
                                        <div class="rounded-xl bg-gray-50 border border-gray-100 p-4 space-y-2 text-sm">
                                            <div class="flex justify-between"><span class="text-gray-500">Status</span><span class="font-semibold text-[#303030]">{{ $pendaftaran->label_status }}</span></div>
                                            <div class="flex justify-between"><span class="text-gray-500">Pembayaran</span><span class="font-semibold text-[#303030]">{{ $pendaftaran->label_bayar }}</span></div>
                                            <div class="flex justify-between"><span class="text-gray-500">Kehadiran</span><span class="font-semibold text-[#303030]">{{ $pendaftaran->label_hadir }}</span></div>
                                        </div>

                                        @if($kegiatan->harga > 0 && $pendaftaran->status_bayar !== 'lunas')
                                            <div class="rounded-xl border border-gray-200 p-4">
                                                <p class="text-sm font-semibold text-[#303030] mb-2">Unggah Bukti Pembayaran</p>
                                                @if($pendaftaran->bukti_bayar)
                                                    <p class="text-xs text-gray-500 mb-2">Bukti sudah diunggah, menunggu verifikasi admin.</p>
                                                @endif
                                                <form method="post" action="{{ route('kegiatan.bukti', [$kegiatan->jenis, $kegiatan->slug]) }}" enctype="multipart/form-data" class="space-y-2">
                                                    @csrf
                                                    <input type="file" name="bukti_bayar" accept=".jpg,.jpeg,.png,.pdf" class="block w-full text-sm text-gray-600">
                                                    @error('bukti_bayar') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                                                    <button type="submit" class="w-full rounded-xl bg-[#ffb600] px-4 py-2.5 text-sm font-bold text-[#252525] hover:bg-[#e6a400] transition">Kirim Bukti</button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                @elseif($sisaKuota !== null && $sisaKuota <= 0)
                                    <div class="rounded-xl bg-red-50 border border-red-100 p-4 text-sm text-red-700 font-medium">Kuota kegiatan sudah penuh.</div>
                                @else
                                    <form method="post" action="{{ route('kegiatan.daftar', [$kegiatan->jenis, $kegiatan->slug]) }}" class="space-y-3">
                                        @csrf
                                        <div>
                                            <label for="nama" class="block text-xs font-semibold text-gray-600 mb-1">Nama Lengkap</label>
                                            <input id="nama" name="nama" type="text" value="{{ old('nama', auth()->user()->name) }}" required class="w-full rounded-xl border-gray-300 text-sm focus:border-[#ffb600] focus:ring-[#ffb600]">
                                            @error('nama') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label for="email" class="block text-xs font-semibold text-gray-600 mb-1">Email</label>
                                            <input id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}" required class="w-full rounded-xl border-gray-300 text-sm focus:border-[#ffb600] focus:ring-[#ffb600]">
                                            @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label for="nomor_hp" class="block text-xs font-semibold text-gray-600 mb-1">Nomor HP</label>
                                            <input id="nomor_hp" name="nomor_hp" type="text" value="{{ old('nomor_hp', auth()->user()->nomor_hp) }}" required class="w-full rounded-xl border-gray-300 text-sm focus:border-[#ffb600] focus:ring-[#ffb600]">
                                            @error('nomor_hp') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label for="instansi" class="block text-xs font-semibold text-gray-600 mb-1">Instansi / Prodi</label>
                                            <input id="instansi" name="instansi" type="text" value="{{ old('instansi', auth()->user()->role === 'mahasiswa' ? auth()->user()->prodi : auth()->user()->unit) }}" class="w-full rounded-xl border-gray-300 text-sm focus:border-[#ffb600] focus:ring-[#ffb600]">
                                            @error('instansi') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                                        </div>
                                        <button type="submit" class="w-full rounded-xl bg-[#ffb600] px-4 py-3 text-sm font-bold text-[#252525] hover:bg-[#e6a400] transition">Daftar Sekarang</button>
                                    </form>
                                @endif
                            @else
                                <div class="rounded-xl bg-gray-50 border border-gray-100 p-4 text-sm text-gray-600">Akun dengan role ini tidak dapat mendaftar kegiatan.</div>
                            @endif
                        @else
                            <div class="text-sm text-gray-600">
                                <p>Masuk terlebih dahulu untuk mendaftar kegiatan ini.</p>
                                <a href="{{ route('login') }}" class="mt-3 inline-flex w-full items-center justify-center rounded-xl bg-[#ffb600] px-4 py-2.5 text-sm font-bold text-[#252525] hover:bg-[#e6a400] transition">Masuk</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
