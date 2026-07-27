@extends('layouts.frontend')

@section('title', 'Kewirausahaan | UPA PKK UBB')

@section('content')
<style>
    .hover-lift {
        transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
    }
    .hover-lift:hover {
        transform: translateY(-6px);
        box-shadow: 0 25px 50px rgba(0,0,0,0.1);
    }
</style>

{{-- HERO --}}
<section class="relative overflow-hidden bg-gradient-to-br from-[#23282d] via-[#2c2c2c] to-[#23282d] py-24 lg:py-32">
    <div class="absolute w-[400px] h-[400px] bg-[#ffb600] rounded-full blur-[120px] opacity-10 top-[-100px] right-[-100px]"></div>
    <div class="absolute w-[300px] h-[300px] bg-[#ffc009] rounded-full blur-[100px] opacity-10 bottom-[-50px] left-[-50px]"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="max-w-3xl" data-reveal="left">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold uppercase tracking-widest text-amber-300 mb-6">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-400"></span>
                </span>
                Program Wirausaha
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-7xl font-black text-white leading-[1.05] tracking-tight mb-6">
                Kewirausahaan<br>
                <span class="bg-gradient-to-r from-yellow-300 via-amber-400 to-yellow-500 bg-clip-text text-transparent">Mahasiswa UBB</span>
            </h1>
            <p class="text-lg sm:text-xl text-slate-300 max-w-xl leading-relaxed mb-8">
                Program PMW & P2MW — wadah pengembangan jiwa wirausaha mahasiswa Universitas Bangka Belitung.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('wirausaha.index') }}" class="group relative overflow-hidden inline-flex items-center gap-2 px-7 py-3.5 bg-[#ffb600] text-white font-bold rounded-full shadow-lg shadow-[#ffb600]/30 hover:shadow-[#ffb600]/50 transition-all duration-300 hover:scale-[1.03] active:scale-[0.97]">
                    <span>Lihat Daftar Usaha</span>
                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- STATISTIK --}}
<section class="bg-gradient-to-r from-yellow-500 to-yellow-600 py-16">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="grid grid-cols-3 gap-6 lg:gap-8">
            <div class="text-center p-6 bg-white/10 backdrop-blur rounded-2xl" data-reveal="up">
                <div class="text-3xl sm:text-4xl font-extrabold text-white">{{ $totalPmw }}</div>
                <div class="text-sm text-yellow-100 mt-1 font-medium">Program PMW</div>
            </div>
            <div class="text-center p-6 bg-white/10 backdrop-blur rounded-2xl" data-reveal="up" data-reveal-delay="100">
                <div class="text-3xl sm:text-4xl font-extrabold text-white">{{ $totalP2mw }}</div>
                <div class="text-sm text-yellow-100 mt-1 font-medium">Program P2MW</div>
            </div>
            <div class="text-center p-6 bg-white/10 backdrop-blur rounded-2xl" data-reveal="up" data-reveal-delay="200">
                <div class="text-3xl sm:text-4xl font-extrabold text-white">{{ $totalUsaha }}</div>
                <div class="text-sm text-yellow-100 mt-1 font-medium">Total Usaha</div>
            </div>
        </div>
    </div>
</section>

{{-- TENTANG PROGRAM --}}
<section class="py-20 lg:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-2 gap-16 items-start">
            <div data-reveal="left">
                <span class="text-yellow-500 font-bold text-xs tracking-[.2em] uppercase">Tentang Program</span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-900 mt-3 mb-4 tracking-tight">Apa itu PMW & P2MW?</h2>
                <div class="space-y-4 text-gray-600 leading-relaxed text-sm sm:text-base">
                    <div class="p-5 bg-yellow-50 rounded-xl border border-yellow-200">
                        <h3 class="font-bold text-gray-900 text-lg mb-1">PMW</h3>
                        <p><strong>Program Mahasiswa Wirausaha</strong> — Program dari Kemendikbudristek yang bertujuan menumbuhkan jiwa wirausaha mahasiswa melalui pendanaan usaha bagi mahasiswa yang memiliki ide bisnis.</p>
                    </div>
                    <div class="p-5 bg-amber-50 rounded-xl border border-amber-200">
                        <h3 class="font-bold text-gray-900 text-lg mb-1">P2MW</h3>
                        <p><strong>Program Pengembangan Mahasiswa Wirausaha</strong> — Program lanjutan untuk mengembangkan usaha mahasiswa yang sudah berjalan agar naik kelas dan lebih kompetitif.</p>
                    </div>
                </div>
            </div>
            <div data-reveal="right">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-900 mb-6 tracking-tight">Usaha Terbaru</h2>
                @if($usahaTerbaru->count() > 0)
                <div class="space-y-4">
                    @foreach($usahaTerbaru as $usaha)
                    <a href="{{ route('wirausaha.show', $usaha->id) }}" class="block bg-gray-50 rounded-xl p-4 border border-gray-100 hover-lift">
                        <div class="flex items-center gap-4">
                            @if($usaha->foto)
                            <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0">
                                <img src="{{ asset('storage/' . $usaha->foto) }}" alt="{{ $usaha->nama_usaha }}" class="w-full h-full object-cover">
                            </div>
                            @else
                            <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-yellow-100 to-amber-100 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72C4.153 3.588 5.954 3 7.5 3c1.464 0 2.886.5 4.013 1.337"/></svg>
                            </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-gray-900 text-sm truncate">{{ $usaha->nama_usaha }}</h3>
                                <p class="text-xs text-gray-500">{{ $usaha->nama_pemilik }} • {{ strtoupper($usaha->program) }}</p>
                            </div>
                            <span class="text-xs font-bold text-yellow-600 shrink-0">{{ $usaha->tahun_kegiatan }}</span>
                        </div>
                    </a>
                    @endforeach
                </div>
                <a href="{{ route('wirausaha.index') }}" class="inline-flex items-center gap-2 mt-6 text-yellow-600 hover:text-yellow-700 font-medium text-sm">
                    Lihat Semua
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                @else
                <div class="text-center py-12 bg-gray-50 rounded-xl">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72C4.153 3.588 5.954 3 7.5 3c1.464 0 2.886.5 4.013 1.337"/></svg>
                    <p class="text-gray-500 font-medium">Belum ada data usaha</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="bg-gradient-to-r from-yellow-500 to-yellow-600 py-16" data-reveal="up">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 text-center">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-white mb-2">Punya Usaha Inovatif?</h2>
        <p class="text-yellow-100 mb-6 max-w-lg mx-auto">Ikuti program PMW atau P2MW dan dapatkan pendanaan untuk mengembangkan usahamu!</p>
        <a href="{{ route('wirausaha.index') }}" class="inline-flex items-center gap-2 px-7 py-3 bg-white text-yellow-700 font-bold rounded-full hover:bg-yellow-50 transition-all duration-300 shadow-lg">
            Lihat Daftar Usaha
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>
</section>
@endsection
