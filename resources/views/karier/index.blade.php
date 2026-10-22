@extends('layouts.frontend')

@section('title', 'Karier | UPA PKK UBB')

@section('content')
<section class="relative overflow-hidden bg-gradient-to-br from-[#23282d] via-[#2c2c2c] to-[#23282d] py-20 lg:py-28">
    <div class="absolute w-[250px] h-[250px] bg-[#ffb600]/10 rounded-full blur-[100px] top-[-50px] left-[-50px]"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <p class="text-amber-300 text-xs font-bold uppercase tracking-[0.25em] mb-4">Pengembangan Karier</p>
        <h1 class="text-3xl lg:text-5xl font-black text-white tracking-tight max-w-3xl">Informasi Karier, Workshop, dan Seminar</h1>
        <p class="text-white/70 text-base lg:text-lg mt-4 max-w-2xl leading-relaxed">Temukan lowongan kerja, kegiatan pengembangan keterampilan, dan seminar pendampingan mahasiswa UPA PKK UBB.</p>
    </div>
</section>

<section class="py-16 lg:py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="grid md:grid-cols-3 gap-6 mb-16">
            <a href="{{ route('lowongan.index') }}" class="group bg-white rounded-2xl border border-gray-100 p-7 shadow-sm hover:shadow-lg hover:border-yellow-200 transition-all duration-300" data-reveal="up">
                <div class="w-12 h-12 rounded-xl bg-[#fff4d6] flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-[#b45309]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <h2 class="text-xl font-bold text-[#252525]">Lowongan Kerja</h2>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">Informasi lowongan dan peluang karier dari mitra industri.</p>
                <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#b45309] mt-5">Lihat lowongan <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></span>
            </a>

            <a href="{{ route('kegiatan.index', 'workshop') }}" class="group bg-white rounded-2xl border border-gray-100 p-7 shadow-sm hover:shadow-lg hover:border-yellow-200 transition-all duration-300" data-reveal="up" data-reveal-delay="100">
                <div class="w-12 h-12 rounded-xl bg-[#fff4d6] flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-[#b45309]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <h2 class="text-xl font-bold text-[#252525]">Workshop</h2>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">Pelatihan praktis untuk meningkatkan keterampilan mahasiswa.</p>
                <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#b45309] mt-5">Lihat workshop <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></span>
            </a>

            <a href="{{ route('kegiatan.index', 'seminar') }}" class="group bg-white rounded-2xl border border-gray-100 p-7 shadow-sm hover:shadow-lg hover:border-yellow-200 transition-all duration-300" data-reveal="up" data-reveal-delay="200">
                <div class="w-12 h-12 rounded-xl bg-[#fff4d6] flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-[#b45309]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <h2 class="text-xl font-bold text-[#252525]">Seminar</h2>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">Seminar dan pendampingan, termasuk pendampingan wisuda.</p>
                <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#b45309] mt-5">Lihat seminar <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></span>
            </a>
        </div>

        <div class="grid lg:grid-cols-2 gap-12">
            <div>
                <div class="flex items-end justify-between mb-6">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#b45309]">Agenda</p>
                        <h2 class="text-2xl font-extrabold text-[#252525] mt-1">Workshop Terbaru</h2>
                    </div>
                    <a href="{{ route('kegiatan.index', 'workshop') }}" class="text-sm font-semibold text-[#b45309] hover:underline">Semua</a>
                </div>
                <div class="space-y-4">
                    @forelse($workshop as $item)
                        <a href="{{ route('kegiatan.show', ['workshop', $item->slug]) }}" class="block bg-white rounded-2xl border border-gray-100 p-5 shadow-sm hover:border-yellow-200 hover:shadow-md transition-all duration-300">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <h3 class="font-bold text-[#252525]">{{ $item->judul }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ $item->tanggal_mulai->translatedFormat('d F Y') }} @if($item->jam_mulai) · {{ substr($item->jam_mulai,0,5) }} WIB @endif</p>
                                </div>
                                <span class="shrink-0 text-xs font-bold px-3 py-1 rounded-full {{ $item->harga > 0 ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">{{ $item->label_harga }}</span>
                            </div>
                        </a>
                    @empty
                        <p class="text-sm text-gray-500 bg-white border border-gray-100 rounded-2xl p-6">Belum ada workshop yang dipublikasikan.</p>
                    @endforelse
                </div>
            </div>

            <div>
                <div class="flex items-end justify-between mb-6">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#b45309]">Agenda</p>
                        <h2 class="text-2xl font-extrabold text-[#252525] mt-1">Seminar Terbaru</h2>
                    </div>
                    <a href="{{ route('kegiatan.index', 'seminar') }}" class="text-sm font-semibold text-[#b45309] hover:underline">Semua</a>
                </div>
                <div class="space-y-4">
                    @forelse($seminar as $item)
                        <a href="{{ route('kegiatan.show', ['seminar', $item->slug]) }}" class="block bg-white rounded-2xl border border-gray-100 p-5 shadow-sm hover:border-yellow-200 hover:shadow-md transition-all duration-300">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <h3 class="font-bold text-[#252525]">{{ $item->judul }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ $item->tanggal_mulai->translatedFormat('d F Y') }} @if($item->jam_mulai) · {{ substr($item->jam_mulai,0,5) }} WIB @endif</p>
                                </div>
                                @if($item->wajib)
                                    <span class="shrink-0 text-xs font-bold px-3 py-1 rounded-full bg-red-100 text-red-700">Wajib</span>
                                @endif
                            </div>
                        </a>
                    @empty
                        <p class="text-sm text-gray-500 bg-white border border-gray-100 rounded-2xl p-6">Belum ada seminar yang dipublikasikan.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
