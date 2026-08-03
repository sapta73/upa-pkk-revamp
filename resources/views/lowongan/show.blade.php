@extends('layouts.frontend')

@section('title', $lowongan->judul . ' | UPA PKK UBB')

@section('content')
<style>
    .hover-lift {
        transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
    }
    .hover-lift:hover {
        transform: translateY(-6px);
        box-shadow: 0 25px 50px rgba(0,0,0,0.1);
    }
    .prose-content h2 { font-size: 1.35rem; font-weight: 700; color: #111827; margin-top: 1.75rem; margin-bottom: 0.75rem; }
    .prose-content p { color: #4b5563; line-height: 1.8; margin-bottom: 1rem; }
    .prose-content ul, .prose-content ol { color: #4b5563; line-height: 1.8; margin-bottom: 1rem; padding-left: 1.5rem; }
    .prose-content ul { list-style: disc; }
    .prose-content ol { list-style: decimal; }
    .prose-content li { margin-bottom: 0.4rem; }
</style>

{{-- HEADER --}}
<section class="relative overflow-hidden bg-gradient-to-br from-[#23282d] via-[#2c2c2c] to-[#23282d] py-20 lg:py-28">
    <div class="absolute w-[400px] h-[400px] bg-[#ffb600] rounded-full blur-[120px] opacity-10 top-[-100px] right-[-100px]"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="max-w-3xl" data-reveal="up">
            <a href="{{ route('lowongan.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-300 hover:text-white transition-colors mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                Semua Lowongan
            </a>
            <div class="flex flex-wrap items-center gap-3 mb-5">
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg text-xs font-semibold
                    @if($lowongan->tipe_pekerjaan == 'full_time') bg-blue-500/20 text-blue-300
                    @elseif($lowongan->tipe_pekerjaan == 'part_time') bg-emerald-500/20 text-emerald-300
                    @elseif($lowongan->tipe_pekerjaan == 'magang') bg-amber-500/20 text-amber-300
                    @else bg-purple-500/20 text-purple-300 @endif">
                    {{ $lowongan->label_tipe }}
                </span>
                @if($lowongan->batas_lamaran && $lowongan->batas_lamaran >= now()->toDateString())
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg text-xs font-semibold bg-red-500/20 text-red-300">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Batas {{ $lowongan->batas_lamaran->format('d M Y') }}
                </span>
                @elseif(!$lowongan->batas_lamaran)
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg text-xs font-semibold bg-emerald-500/20 text-emerald-300">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                    </span>
                    Masih Dibuka
                </span>
                @endif
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-[1.1] tracking-tight">
                {{ $lowongan->judul }}
            </h1>
            <div class="flex flex-wrap items-center gap-x-6 gap-y-2 mt-5 text-slate-300 text-sm">
                <span class="inline-flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    {{ $lowongan->perusahaan }}
                </span>
                <span class="inline-flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $lowongan->lokasi }}
                </span>
                <span class="inline-flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Diposting {{ $lowongan->created_at->format('d M Y') }}
                </span>
            </div>
        </div>
    </div>
</section>

{{-- DETAIL --}}
<section class="py-12 lg:py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-3 gap-8">
            {{-- KONTEN UTAMA --}}
            <div class="lg:col-span-2 space-y-6" data-reveal="up">
                <div class="bg-white rounded-2xl border border-gray-100 p-6 lg:p-8">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2 mb-4">
                        <span class="w-1.5 h-6 bg-yellow-500 rounded-full"></span>
                        Deskripsi Pekerjaan
                    </h2>
                    <div class="prose-content">
                        {!! nl2br(e($lowongan->deskripsi)) !!}
                    </div>
                </div>

                @if($lowongan->persyaratan)
                <div class="bg-white rounded-2xl border border-gray-100 p-6 lg:p-8">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2 mb-4">
                        <span class="w-1.5 h-6 bg-yellow-500 rounded-full"></span>
                        Persyaratan / Kualifikasi
                    </h2>
                    <div class="prose-content">
                        {!! nl2br(e($lowongan->persyaratan)) !!}
                    </div>
                </div>
                @endif
            </div>

            {{-- SIDEBAR --}}
            <aside class="space-y-6" data-reveal="up" data-reveal-delay="100">
                <div class="bg-white rounded-2xl border border-gray-100 p-6 lg:p-7">
                    <h3 class="font-bold text-gray-900 mb-5">Informasi Lowongan</h3>
                    <dl class="space-y-4 text-sm">
                        <div class="flex items-start justify-between gap-3">
                            <dt class="text-gray-500 flex items-center gap-2">
                                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                Perusahaan
                            </dt>
                            <dd class="text-gray-900 font-medium text-right">{{ $lowongan->perusahaan }}</dd>
                        </div>
                        <div class="flex items-start justify-between gap-3">
                            <dt class="text-gray-500 flex items-center gap-2">
                                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Lokasi
                            </dt>
                            <dd class="text-gray-900 font-medium text-right">{{ $lowongan->lokasi }}</dd>
                        </div>
                        <div class="flex items-start justify-between gap-3">
                            <dt class="text-gray-500 flex items-center gap-2">
                                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                Tipe
                            </dt>
                            <dd class="text-gray-900 font-medium">{{ $lowongan->label_tipe }}</dd>
                        </div>
                        @if($lowongan->gaji)
                        <div class="flex items-start justify-between gap-3">
                            <dt class="text-gray-500 flex items-center gap-2">
                                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Gaji
                            </dt>
                            <dd class="text-gray-900 font-semibold text-right">{{ $lowongan->gaji }}</dd>
                        </div>
                        @endif
                        @if($lowongan->kuota)
                        <div class="flex items-start justify-between gap-3">
                            <dt class="text-gray-500 flex items-center gap-2">
                                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                Kuota
                            </dt>
                            <dd class="text-gray-900 font-medium">{{ $lowongan->kuota }} orang</dd>
                        </div>
                        @endif
                        @if($lowongan->batas_lamaran)
                        <div class="flex items-start justify-between gap-3">
                            <dt class="text-gray-500 flex items-center gap-2">
                                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Batas Lamaran
                            </dt>
                            <dd class="text-gray-900 font-medium">{{ $lowongan->batas_lamaran->format('d M Y') }}</dd>
                        </div>
                        @endif
                        @if($lowongan->kontak)
                        <div class="flex items-start justify-between gap-3">
                            <dt class="text-gray-500 flex items-center gap-2">
                                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                Kontak
                            </dt>
                            <dd class="text-gray-900 font-medium text-right break-all">{{ $lowongan->kontak }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>

                <div class="bg-gradient-to-br from-yellow-500 to-amber-600 rounded-2xl p-6 lg:p-7 text-white shadow-lg shadow-yellow-500/20">
                    <h3 class="font-bold text-lg mb-2">Tertarik melamar?</h3>
                    <p class="text-sm text-yellow-50 mb-5 leading-relaxed">
                        Siapkan CV terbaikmu dan daftar sebelum batas waktu pendaftaran ditutup.
                    </p>
                    @if($lowongan->link_pendaftaran)
                    <a href="{{ $lowongan->link_pendaftaran }}" target="_blank" rel="noopener"
                       class="block w-full text-center px-5 py-3 bg-white text-amber-700 font-bold rounded-xl hover:bg-yellow-50 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                        Daftar Sekarang
                        <span class="inline-flex ml-1">↗</span>
                    </a>
                    @else
                    <div class="px-5 py-3 bg-white/15 backdrop-blur rounded-xl text-sm text-yellow-50 text-center">
                        Silakan hubungi kontak pada informasi lowongan
                    </div>
                    @endif
                </div>
            </aside>
        </div>

        {{-- LOWONGAN LAINNYA --}}
        @if($lowonganLainnya->count() > 0)
        <div class="mt-14" data-reveal="up">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Lowongan Lainnya</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($lowonganLainnya as $lain)
                <a href="{{ route('lowongan.show', $lain->id) }}" class="group block bg-white rounded-2xl border border-gray-100 hover-lift overflow-hidden">
                    <div class="p-5">
                        <h3 class="font-bold text-gray-900 text-base leading-snug group-hover:text-yellow-600 transition-colors">{{ $lain->judul }}</h3>
                        <p class="text-sm text-gray-500 mt-1">{{ $lain->perusahaan }} • {{ $lain->lokasi }}</p>
                        <div class="flex flex-wrap gap-2 mt-3">
                            <span class="inline-flex px-2.5 py-0.5 rounded-lg text-xs font-medium
                                @if($lain->tipe_pekerjaan == 'full_time') bg-blue-50 text-blue-700
                                @elseif($lain->tipe_pekerjaan == 'part_time') bg-emerald-50 text-emerald-700
                                @elseif($lain->tipe_pekerjaan == 'magang') bg-amber-50 text-amber-700
                                @else bg-purple-50 text-purple-700 @endif">
                                {{ $lain->label_tipe }}
                            </span>
                            @if($lain->batas_lamaran)
                            <span class="inline-flex px-2.5 py-0.5 rounded-lg text-xs text-gray-500 bg-gray-100">Batas {{ $lain->batas_lamaran->format('d M') }}</span>
                            @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
