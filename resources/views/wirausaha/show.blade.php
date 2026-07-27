@extends('layouts.frontend')

@section('title', $usaha->nama_usaha . ' | UPA PKK UBB')

@section('content')
<section class="relative overflow-hidden bg-gradient-to-br from-[#23282d] via-[#2c2c2c] to-[#23282d] py-20 lg:py-28">
    <div class="absolute w-[250px] h-[250px] bg-[#ffb600]/10 rounded-full blur-[100px] top-[-50px] left-[-50px]"></div>
    <div class="absolute w-[200px] h-[200px] bg-[#ffc009]/10 rounded-full blur-[80px] bottom-[-30px] right-[-30px]"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <a href="{{ route('wirausaha.index') }}" class="inline-flex items-center gap-2 text-white/60 hover:text-white mb-8 transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
            <span class="text-sm">Kembali ke daftar usaha</span>
        </a>
        <div class="flex items-center gap-6 lg:gap-8" data-reveal="left">
            @if($usaha->foto)
            <div class="w-28 h-28 lg:w-36 lg:h-36 rounded-3xl border-4 border-white/20 overflow-hidden shadow-2xl shrink-0 bg-white">
                <img src="{{ asset('storage/' . $usaha->foto) }}" alt="{{ $usaha->nama_usaha }}" class="w-full h-full object-cover">
            </div>
            @else
            <div class="w-28 h-28 lg:w-36 lg:h-36 rounded-3xl border-4 border-white/20 overflow-hidden shadow-2xl shrink-0 bg-gradient-to-br from-yellow-100 to-amber-100 flex items-center justify-center">
                <svg class="w-12 h-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72C4.153 3.588 5.954 3 7.5 3c1.464 0 2.886.5 4.013 1.337"/></svg>
            </div>
            @endif
            <div>
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold {{ $usaha->program == 'pmw' ? 'text-green-300' : 'text-amber-300' }} mb-3">
                    {{ strtoupper($usaha->program) }}
                </span>
                <h1 class="text-3xl lg:text-5xl font-black text-white leading-tight tracking-tight">{{ $usaha->nama_usaha }}</h1>
                <p class="text-lg text-slate-300 font-medium mt-1">{{ $usaha->nama_pemilik }}</p>
            </div>
        </div>
    </div>
</section>

{{-- DETAIL --}}
<section class="py-16 lg:py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-3 gap-10 lg:gap-16">
            {{-- KONTEN UTAMA --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- DESKRIPSI --}}
                <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm" data-reveal="up">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        Deskripsi Usaha
                    </h2>
                    <p class="text-gray-600 leading-relaxed">{{ $usaha->deskripsi ?? 'Belum ada deskripsi.' }}</p>
                </div>

                {{-- FOTO --}}
                @if($usaha->foto)
                <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm" data-reveal="up" data-reveal-delay="100">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Foto Usaha
                    </h2>
                    <img src="{{ asset('storage/' . $usaha->foto) }}" alt="{{ $usaha->nama_usaha }}" class="w-full rounded-xl">
                </div>
                @endif

                {{-- SK PENDANAAN --}}
                @if($usaha->sk_pendanaan)
                <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm" data-reveal="up" data-reveal-delay="150">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        SK Pendanaan
                    </h2>
                    <a href="{{ asset('storage/' . $usaha->sk_pendanaan) }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 bg-yellow-500 text-white font-semibold rounded-xl hover:bg-yellow-600 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Lihat SK Pendanaan (PDF)
                    </a>
                </div>
                @endif
            </div>

            {{-- SIDEBAR --}}
            <div class="space-y-6" data-reveal="right">
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                    <h3 class="font-bold text-gray-900 mb-4">Informasi Usaha</h3>
                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Program</span>
                            <span class="font-semibold {{ $usaha->program == 'pmw' ? 'text-green-600' : 'text-amber-600' }}">{{ strtoupper($usaha->program) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Pemilik</span>
                            <span class="font-semibold text-gray-900">{{ $usaha->nama_pemilik }}</span>
                        </div>
                        @if($usaha->nim)
                        <div class="flex justify-between">
                            <span class="text-gray-500">NIM</span>
                            <span class="font-semibold text-gray-900">{{ $usaha->nim }}</span>
                        </div>
                        @endif
                        @if($usaha->jenis_usaha)
                        <div class="flex justify-between">
                            <span class="text-gray-500">Jenis Usaha</span>
                            <span class="font-semibold text-gray-900">{{ $usaha->jenis_usaha }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-500">Tahun</span>
                            <span class="font-semibold text-gray-900">{{ $usaha->tahun_kegiatan ?? '-' }}</span>
                        </div>
                        @if($usaha->modal_dana)
                        <div class="flex justify-between border-t border-gray-100 pt-4">
                            <span class="text-gray-500">Modal/Dana</span>
                            <span class="font-bold text-green-600">Rp {{ number_format($usaha->modal_dana, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between border-t border-gray-100 pt-4">
                            <span class="text-gray-500">Status</span>
                            @if($usaha->status_aktif)
                            <span class="inline-flex items-center gap-1 text-green-600 font-semibold">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                Aktif
                            </span>
                            @else
                            <span class="text-gray-400 font-semibold">Tidak Aktif</span>
                            @endif
                        </div>
                    </div>
                </div>

                <a href="{{ route('wirausaha.index') }}" class="block w-full text-center px-5 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all text-sm">
                    ← Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
