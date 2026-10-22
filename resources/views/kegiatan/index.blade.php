@extends('layouts.frontend')

@section('title', ucfirst($jenis) . ' | UPA PKK UBB')

@section('content')
@php
    $judul = $jenis === 'workshop' ? 'Workshop' : 'Seminar';
@endphp

<section class="relative overflow-hidden bg-gradient-to-br from-[#23282d] via-[#2c2c2c] to-[#23282d] py-20 lg:py-24">
    <div class="absolute w-[250px] h-[250px] bg-[#ffb600]/10 rounded-full blur-[100px] top-[-50px] right-[-50px]"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <a href="{{ route('karier.index') }}" class="inline-flex items-center gap-2 text-white/60 hover:text-white mb-6 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
            <span class="text-sm">Kembali ke Karier</span>
        </a>
        <h1 class="text-3xl lg:text-5xl font-black text-white tracking-tight">{{ $judul }} UPA PKK UBB</h1>
        <p class="text-white/70 text-base lg:text-lg mt-4 max-w-2xl leading-relaxed">
            @if($jenis === 'workshop')
                Ikuti pelatihan praktis untuk mengembangkan keterampilan dan kesiapan karier.
            @else
                Ikuti seminar dan pendampingan yang diselenggarakan UPA PKK UBB.
            @endif
        </p>

        <div class="flex gap-2 mt-8">
            <a href="{{ route('kegiatan.index', 'workshop') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold transition {{ $jenis === 'workshop' ? 'bg-[#ffb600] text-[#252525]' : 'bg-white/10 text-white hover:bg-white/20' }}">Workshop</a>
            <a href="{{ route('kegiatan.index', 'seminar') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold transition {{ $jenis === 'seminar' ? 'bg-[#ffb600] text-[#252525]' : 'bg-white/10 text-white hover:bg-white/20' }}">Seminar</a>
        </div>
    </div>
</section>

<section class="py-16 lg:py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        @if($kegiatan->isEmpty())
            <div class="bg-white border border-gray-100 rounded-2xl p-10 text-center">
                <h2 class="text-xl font-bold text-[#252525]">Belum ada {{ strtolower($judul) }}</h2>
                <p class="text-sm text-gray-500 mt-2">Silakan cek kembali nanti.</p>
            </div>
        @else
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($kegiatan as $item)
                    <a href="{{ route('kegiatan.show', [$jenis, $item->slug]) }}" class="group bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-lg hover:border-yellow-200 transition-all duration-300 flex flex-col">
                        <div class="h-44 bg-gradient-to-br from-[#fff4d6] to-[#ffe6a3] overflow-hidden">
                            @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-14 h-14 text-[#b45309]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-5 flex flex-col flex-1">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-[11px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full bg-[#fff4d6] text-[#b45309]">{{ $judul }}</span>
                                @if($item->wajib)
                                    <span class="text-[11px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full bg-red-100 text-red-700">Wajib</span>
                                @endif
                            </div>
                            <h2 class="font-bold text-[#252525] text-lg leading-snug">{{ $item->judul }}</h2>
                            <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ Str::limit(strip_tags($item->deskripsi), 110) }}</p>
                            <div class="mt-4 space-y-1.5 text-sm text-gray-600">
                                <p>{{ $item->tanggal_mulai->translatedFormat('d F Y') }} @if($item->jam_mulai) · {{ substr($item->jam_mulai, 0, 5) }} WIB @endif</p>
                                @if($item->lokasi)<p>{{ $item->lokasi }}</p>@endif
                            </div>
                            <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-between">
                                <span class="text-sm font-bold {{ $item->harga > 0 ? 'text-[#b45309]' : 'text-green-700' }}">{{ $item->label_harga }}</span>
                                <span class="text-sm font-semibold text-[#303030] group-hover:text-[#b45309] transition">Lihat Detail</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $kegiatan->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
