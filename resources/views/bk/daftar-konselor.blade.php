@extends('layouts.frontend')

@section('title', 'Daftar Konselor | UPA PKK UBB')

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

<section class="relative overflow-hidden bg-gradient-to-br from-[#23282d] via-[#2c2c2c] to-[#23282d] py-24 lg:py-32">
    <div class="absolute w-[300px] h-[300px] bg-[#ffb600]/10 rounded-full blur-[100px] top-[-80px] right-[-80px]"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="max-w-2xl" data-reveal="left">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold uppercase tracking-widest text-amber-300 mb-6">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-400"></span>
                </span>
                Pilih Konselor
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-[1.05] tracking-tight mb-4">
                Temukan Konselor<br>
                <span class="bg-gradient-to-r from-yellow-300 via-amber-400 to-yellow-500 bg-clip-text text-transparent">Terbaik untukmu</span>
            </h1>
            <p class="text-lg text-slate-300 max-w-lg leading-relaxed">
                Pilih konselor yang sesuai dengan kebutuhan karir dan personalmu. Semua konselor adalah profesional berpengalaman.
            </p>
        </div>
    </div>
</section>

<section class="py-20 lg:py-28 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8" data-stagger>
            @forelse($konselors as $k)
            <a href="{{ route('bk.konselor.profil', $k->id) }}" class="group block bg-white rounded-2xl border border-gray-100 hover-lift overflow-hidden">
                <div class="relative h-48 bg-gradient-to-br from-yellow-400 to-amber-500 overflow-hidden">
                    <div class="absolute inset-0 bg-black/10"></div>
                    <div class="absolute -bottom-12 left-6">
                        <div class="w-24 h-24 rounded-2xl border-4 border-white overflow-hidden shadow-xl bg-white">
                            @if($k->foto)
                                <img src="{{ asset('storage/' . $k->foto) }}" alt="{{ $k->nama }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-yellow-100 to-amber-100 flex items-center justify-center text-3xl font-black text-yellow-600">{{ substr($k->nama, 0, 1) }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="absolute top-4 right-4">
                        <span class="px-2.5 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold text-yellow-700 shadow-sm">Aktif</span>
                    </div>
                </div>
                <div class="pt-16 p-6">
                    <h3 class="font-bold text-gray-900 text-lg">{{ $k->nama }}</h3>
                    <p class="text-sm text-yellow-600 font-medium mt-0.5">{{ $k->spesialisasi }}</p>
                    <p class="text-sm text-gray-500 mt-3 leading-relaxed line-clamp-2">{{ $k->bio ?? 'Konselor profesional siap membantu pengembangan karir dan personal Anda.' }}</p>
                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                        <div class="flex items-center gap-1 text-amber-500">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="text-xs text-gray-600">4.9</span>
                            <span class="text-xs text-gray-400">(128)</span>
                        </div>
                        <span class="text-sm font-semibold text-yellow-600 group-hover:underline">Pilih Jadwal</span>
                    </div>
                </div>
            </a>
            @empty
            <div class="lg:col-span-3 text-center py-20">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Belum Ada Konselor</h3>
                <p class="text-gray-500 mt-1">Saat ini belum ada konselor yang tersedia. Silakan cek kembali nanti.</p>
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 mt-6 text-yellow-600 hover:text-yellow-700 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                    Kembali ke Beranda
                </a>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
