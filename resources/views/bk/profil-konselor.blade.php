@extends('layouts.frontend')

@section('title', $konselor->nama . ' | Bimbingan Konseling UPA PKK UBB')

@section('content')
<section class="relative overflow-hidden bg-gradient-to-br from-[#23282d] via-[#2c2c2c] to-[#23282d] py-20 lg:py-28">
    <div class="absolute w-[250px] h-[250px] bg-[#ffb600]/10 rounded-full blur-[100px] top-[-50px] left-[-50px]"></div>
    <div class="absolute w-[200px] h-[200px] bg-[#ffc009]/10 rounded-full blur-[80px] bottom-[-30px] right-[-30px]"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <a href="{{ route('bk.konselor') }}" class="inline-flex items-center gap-2 text-white/60 hover:text-white mb-8 transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
            <span class="text-sm">Kembali ke daftar konselor</span>
        </a>
        <div class="flex items-center gap-6 lg:gap-8" data-reveal="left">
            <div class="w-28 h-28 lg:w-36 lg:h-36 rounded-3xl border-4 border-white/20 overflow-hidden shadow-2xl shrink-0 bg-white">
                @if($konselor->foto)
                    <img src="{{ asset('storage/' . $konselor->foto) }}" alt="{{ $konselor->nama }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-yellow-100 to-amber-100 flex items-center justify-center text-5xl font-black text-yellow-600">{{ substr($konselor->nama, 0, 1) }}</div>
                @endif
            </div>
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold text-amber-300 mb-3">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-400"></span>
                    </span>
                    Tersedia
                </div>
                <h1 class="text-3xl lg:text-5xl font-black text-white leading-tight tracking-tight">{{ $konselor->nama }}</h1>
                <p class="text-lg text-amber-300 font-medium mt-1">{{ $konselor->spesialisasi }}</p>
            </div>
        </div>
    </div>
</section>

<section class="py-16 lg:py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-3 gap-10 lg:gap-16">
            {{-- Left: Konten --}}
            <div class="lg:col-span-2 space-y-10">
                {{-- Bio --}}
                <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm" data-reveal="up">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Biografi
                    </h2>
                    <p class="text-gray-600 leading-relaxed">{{ $konselor->bio ?? 'Belum ada biografi.' }}</p>
                </div>

                {{-- Jadwal Timeline --}}
                <div data-reveal="up" data-reveal-delay="100">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Jadwal Tersedia
                    </h2>
                    @if($konselor->jadwals->where('status_aktif', true)->count() > 0)
                    <div class="space-y-3">
                        @foreach($konselor->jadwals->where('status_aktif', true) as $jadwal)
                        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm hover:border-yellow-200 hover:shadow-md transition-all duration-300 group">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center group-hover:bg-yellow-500 transition-colors">
                                        <svg class="w-5 h-5 text-yellow-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 capitalize text-base">{{ $jadwal->hari }}</div>
                                        <div class="text-sm text-gray-500">{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }} WIB</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-100 rounded-lg text-xs font-medium text-gray-600">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        Kuota {{ $jadwal->kuota }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="bg-white rounded-xl p-8 border border-gray-100 text-center">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-gray-500 font-medium">Belum ada jadwal tersedia</p>
                        <p class="text-sm text-gray-400 mt-1">Konselor belum mengatur jadwal</p>
                    </div>
                    @endif
                </div>

                {{-- Contact info --}}
                <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm" data-reveal="up" data-reveal-delay="200">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Kontak
                    </h2>
                    <div class="grid sm:grid-cols-2 gap-4 text-sm">
                        @if($konselor->email)
                        <div class="flex items-center gap-3 text-gray-600">
                            <svg class="w-4 h-4 text-yellow-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            {{ $konselor->email }}
                        </div>
                        @endif
                        @if($konselor->nomor_hp)
                        <div class="flex items-center gap-3 text-gray-600">
                            <svg class="w-4 h-4 text-yellow-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            @if($konselor->link_wa)
                            <a href="{{ $konselor->link_wa }}" target="_blank" rel="noopener" class="hover:text-green-600 transition">{{ $konselor->nomor_hp }}</a>
                            @else
                            {{ $konselor->nomor_hp }}
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right: Sticky Booking Card --}}
            <div class="lg:col-span-1" data-reveal="right" data-reveal-delay="150">
                <div class="lg:sticky lg:top-28 space-y-4">
                    <div class="bg-white rounded-2xl p-6 lg:p-8 border border-gray-100 shadow-sm">
                        <h3 class="font-bold text-gray-900 text-lg mb-2">Booking Konseling</h3>
                        <p class="text-sm text-gray-500 mb-6">Pilih jadwal dan booking sesi konseling dengan {{ $konselor->nama }}.</p>

                        @auth
                            @if(auth()->user()->role === 'mahasiswa')
                            <a href="{{ url('/mahasiswa/booking/' . $konselor->id) }}" class="group relative overflow-hidden inline-flex items-center justify-center gap-2 w-full px-6 py-3.5 bg-[#ffb600] text-white font-bold rounded-xl shadow-lg shadow-[#ffb600]/30 hover:shadow-[#ffb600]/50 transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                Booking Sekarang
                            </a>
                            @else
                            <div class="text-center">
                                <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <p class="text-sm text-gray-500 font-medium">Login sebagai mahasiswa untuk booking</p>
                                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 mt-4 px-6 py-2.5 bg-[#ffb600] text-white font-medium rounded-xl hover:bg-[#e6a400] transition-all duration-300">
                                    Login
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                                </a>
                            </div>
                        @endif
                        @else
                        <div class="text-center">
                            <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <p class="text-sm text-gray-500 font-medium">Login untuk booking sesi konseling</p>
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 mt-4 px-6 py-2.5 bg-[#ffb600] text-white font-medium rounded-xl hover:bg-[#e6a400] transition-all duration-300">
                                Login / Daftar
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            </a>
                        </div>
                    @endauth
                    @if($konselor->link_wa)
                    <a href="{{ $konselor->link_wa }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 w-full px-6 py-3 bg-green-500/10 border border-green-200 text-green-700 font-medium rounded-xl hover:bg-green-500/20 transition-all duration-300">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Konseling via WhatsApp
                    </a>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
