@extends('layouts.frontend')

@section('title', 'Daftar Usaha PMW & P2MW | UPA PKK UBB')

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

{{-- HEADER --}}
<section class="relative overflow-hidden bg-gradient-to-br from-[#23282d] via-[#2c2c2c] to-[#23282d] py-24 lg:py-32">
    <div class="absolute w-[300px] h-[300px] bg-[#ffb600]/10 rounded-full blur-[100px] top-[-80px] right-[-80px]"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="max-w-2xl" data-reveal="left">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold uppercase tracking-widest text-amber-300 mb-6">
                Daftar Usaha
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-[1.05] tracking-tight mb-4">
                Usaha Mahasiswa<br>
                <span class="bg-gradient-to-r from-yellow-300 via-amber-400 to-yellow-500 bg-clip-text text-transparent">PMW & P2MW</span>
            </h1>
            <p class="text-lg text-slate-300 max-w-lg leading-relaxed">
                Jelajahi berbagai usaha mahasiswa Universitas Bangka Belitung yang didanai melalui program PMW dan P2MW.
            </p>
        </div>
    </div>
</section>

{{-- FILTER --}}
<section class="bg-white border-b border-gray-100 sticky top-[72px] lg:top-[80px] z-30">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 py-4">
        <form method="GET" action="{{ route('wirausaha.index') }}" class="flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari usaha, pemilik, atau jenis..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-yellow-500 focus:border-transparent outline-none transition-all">
            </div>
            <select name="program" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-yellow-500 focus:border-transparent outline-none transition-all">
                <option value="">Semua Program</option>
                <option value="pmw" {{ request('program') == 'pmw' ? 'selected' : '' }}>PMW</option>
                <option value="p2mw" {{ request('program') == 'p2mw' ? 'selected' : '' }}>P2MW</option>
            </select>
            <select name="tahun" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-yellow-500 focus:border-transparent outline-none transition-all">
                <option value="">Semua Tahun</option>
                @foreach($tahunList as $tahun)
                <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-5 py-2.5 bg-yellow-500 text-white font-semibold rounded-xl hover:bg-yellow-600 transition-all text-sm">Filter</button>
            @if(request()->anyFilled(['search', 'program', 'tahun']))
            <a href="{{ route('wirausaha.index') }}" class="px-4 py-2.5 text-sm text-gray-500 hover:text-gray-700 transition-all">Reset</a>
            @endif
        </form>
    </div>
</section>

{{-- LIST USAHA --}}
<section class="py-12 lg:py-16 bg-gray-50 min-h-[50vh]">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        @if($usahaList->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8" data-stagger>
            @foreach($usahaList as $usaha)
            <a href="{{ route('wirausaha.show', $usaha->id) }}" class="group block bg-white rounded-2xl border border-gray-100 hover-lift overflow-hidden">
                @if($usaha->foto)
                <div class="relative h-48 overflow-hidden bg-gray-100">
                    <img src="{{ asset('storage/' . $usaha->foto) }}" alt="{{ $usaha->nama_usaha }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-3 right-3">
                        <span class="px-2.5 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold {{ $usaha->program == 'pmw' ? 'text-green-700' : 'text-amber-700' }} shadow-sm">
                            {{ strtoupper($usaha->program) }}
                        </span>
                    </div>
                </div>
                @else
                <div class="relative h-48 bg-gradient-to-br from-yellow-50 to-amber-50 flex items-center justify-center">
                    <svg class="w-16 h-16 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72C4.153 3.588 5.954 3 7.5 3c1.464 0 2.886.5 4.013 1.337"/></svg>
                    <div class="absolute top-3 right-3">
                        <span class="px-2.5 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold {{ $usaha->program == 'pmw' ? 'text-green-700' : 'text-amber-700' }} shadow-sm">
                            {{ strtoupper($usaha->program) }}
                        </span>
                    </div>
                </div>
                @endif
                <div class="p-5">
                    <h3 class="font-bold text-gray-900 text-base group-hover:text-yellow-600 transition-colors">{{ $usaha->nama_usaha }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $usaha->nama_pemilik }} • {{ $usaha->tahun_kegiatan }}</p>
                    @if($usaha->jenis_usaha)
                    <div class="mt-3">
                        <span class="inline-block px-2.5 py-0.5 bg-gray-100 rounded-lg text-xs text-gray-600">{{ $usaha->jenis_usaha }}</span>
                    </div>
                    @endif
                    @if($usaha->deskripsi)
                    <p class="text-sm text-gray-500 mt-3 line-clamp-2">{{ $usaha->deskripsi }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>

        {{-- PAGINATION --}}
        <div class="mt-10">
            {{ $usahaList->links() }}
        </div>
        @else
        <div class="text-center py-20">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72C4.153 3.588 5.954 3 7.5 3c1.464 0 2.886.5 4.013 1.337"/></svg>
            <h3 class="text-lg font-bold text-gray-900">Belum Ada Data Usaha</h3>
            <p class="text-gray-500 mt-1">Belum ada usaha yang terdaftar untuk ditampilkan.</p>
            <a href="{{ route('wirausaha.landing') }}" class="inline-flex items-center gap-2 mt-6 text-yellow-600 hover:text-yellow-700 font-medium text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                Kembali
            </a>
        </div>
        @endif
    </div>
</section>
@endsection
