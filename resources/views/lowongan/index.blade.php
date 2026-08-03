@extends('layouts.frontend')

@section('title', 'Lowongan Kerja | UPA PKK UBB')

@section('content')
<style>
    .hover-lift {
        transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
    }
    .hover-lift:hover {
        transform: translateY(-6px);
        box-shadow: 0 25px 50px rgba(0,0,0,0.1);
    }
    .badge-tipe {
        transition: all 0.25s cubic-bezier(0.4,0,0.2,1);
    }
    .badge-tipe:hover {
        transform: scale(1.05);
    }
</style>

{{-- HEADER --}}
<section class="relative overflow-hidden bg-gradient-to-br from-[#23282d] via-[#2c2c2c] to-[#23282d] py-24 lg:py-32">
    <div class="absolute w-[400px] h-[400px] bg-[#ffb600] rounded-full blur-[120px] opacity-10 top-[-100px] right-[-100px]"></div>
    <div class="absolute w-[300px] h-[300px] bg-[#ffc009] rounded-full blur-[100px] opacity-10 bottom-[-50px] left-[-50px]"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="max-w-2xl" data-reveal="left">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold uppercase tracking-widest text-amber-300 mb-6">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-400"></span>
                </span>
                Karir & Peluang Kerja
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-[1.05] tracking-tight mb-4">
                Lowongan<br>
                <span class="bg-gradient-to-r from-yellow-300 via-amber-400 to-yellow-500 bg-clip-text text-transparent">Pekerjaan</span>
            </h1>
            <p class="text-lg text-slate-300 max-w-lg leading-relaxed">
                Temukan peluang karir terbaru dari berbagai perusahaan dan instansi mitra UPA PKK Universitas Bangka Belitung.
            </p>
        </div>
    </div>
</section>

{{-- FILTER --}}
<section class="bg-white border-b border-gray-100 sticky top-[72px] lg:top-[80px] z-30">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 py-4">
        <form method="GET" action="{{ route('lowongan.index') }}" class="flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, perusahaan, posisi..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-yellow-500 focus:border-transparent outline-none transition-all">
            </div>
            <select name="tipe" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-yellow-500 focus:border-transparent outline-none transition-all">
                <option value="">Semua Tipe</option>
                <option value="full_time" {{ request('tipe') == 'full_time' ? 'selected' : '' }}>Full Time</option>
                <option value="part_time" {{ request('tipe') == 'part_time' ? 'selected' : '' }}>Part Time</option>
                <option value="magang" {{ request('tipe') == 'magang' ? 'selected' : '' }}>Magang</option>
                <option value="kontrak" {{ request('tipe') == 'kontrak' ? 'selected' : '' }}>Kontrak</option>
            </select>
            <select name="lokasi" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-yellow-500 focus:border-transparent outline-none transition-all">
                <option value="">Semua Lokasi</option>
                @foreach($daftarLokasi as $lokasi)
                <option value="{{ $lokasi }}" {{ request('lokasi') == $lokasi ? 'selected' : '' }}>{{ $lokasi }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-5 py-2.5 bg-yellow-500 text-white font-semibold rounded-xl hover:bg-yellow-600 transition-all text-sm">Filter</button>
            @if(request()->anyFilled(['search', 'tipe', 'lokasi']))
            <a href="{{ route('lowongan.index') }}" class="px-4 py-2.5 text-sm text-gray-500 hover:text-gray-700 transition-all">Reset</a>
            @endif
        </form>
    </div>
</section>

{{-- LIST LOWONGAN --}}
<section class="py-12 lg:py-16 bg-gray-50 min-h-[50vh]">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        @if($lowonganList->count() > 0)
        <div class="flex items-center justify-between mb-8">
            <p class="text-sm text-gray-500">
                Menampilkan <span class="font-semibold text-gray-900">{{ $lowonganList->total() }}</span> lowongan pekerjaan
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8" data-stagger>
            @foreach($lowonganList as $lowongan)
            <a href="{{ route('lowongan.show', $lowongan->id) }}" class="group block bg-white rounded-2xl border border-gray-100 hover-lift overflow-hidden flex flex-col">
                <div class="p-6 flex-1">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-500 to-amber-500 flex items-center justify-center shrink-0 shadow-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-base leading-snug group-hover:text-yellow-600 transition-colors">{{ $lowongan->judul }}</h3>
                                <p class="text-sm text-gray-500 mt-0.5">{{ $lowongan->perusahaan }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2 mt-4">
                        <span class="badge-tipe inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium
                            @if($lowongan->tipe_pekerjaan == 'full_time') bg-blue-50 text-blue-700
                            @elseif($lowongan->tipe_pekerjaan == 'part_time') bg-emerald-50 text-emerald-700
                            @elseif($lowongan->tipe_pekerjaan == 'magang') bg-amber-50 text-amber-700
                            @else bg-purple-50 text-purple-700 @endif">
                            {{ $lowongan->label_tipe }}
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs text-gray-600 bg-gray-100">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $lowongan->lokasi }}
                        </span>
                    </div>

                    @if($lowongan->deskripsi)
                    <p class="text-sm text-gray-500 mt-4 line-clamp-2">{{ $lowongan->deskripsi }}</p>
                    @endif
                </div>

                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/60 flex items-center justify-between">
                    <span class="text-xs text-gray-500">
                        @if($lowongan->batas_lamaran)
                            Batas: <span class="font-semibold text-gray-700">{{ $lowongan->batas_lamaran->format('d M Y') }}</span>
                        @else
                            <span class="font-semibold text-emerald-600">Selalu dibuka</span>
                        @endif
                    </span>
                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-yellow-600 group-hover:gap-2 transition-all">
                        Lihat Detail
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </div>
            </a>
            @endforeach
        </div>

        {{-- PAGINATION --}}
        <div class="mt-10">
            {{ $lowonganList->links() }}
        </div>
        @else
        <div class="text-center py-20">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            <h3 class="text-lg font-bold text-gray-900">Belum Ada Lowongan Kerja</h3>
            <p class="text-gray-500 mt-1">Belum ada lowongan pekerjaan yang tersedia saat ini.</p>
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 mt-6 text-yellow-600 hover:text-yellow-700 font-medium text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                Kembali ke Beranda
            </a>
        </div>
        @endif
    </div>
</section>
@endsection
