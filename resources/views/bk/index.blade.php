@extends('layouts.frontend')

@section('title', 'Bimbingan Konseling | UPA PKK UBB')

@section('content')
<style>
    .blob-bg {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.15;
        pointer-events: none;
        animation: blobFloat 8s ease-in-out infinite alternate;
    }
    @keyframes blobFloat {
        0% { transform: translate(0, 0) scale(1); }
        100% { transform: translate(30px, -30px) scale(1.1); }
    }
    @keyframes shimmer {
        0% { background-position: -200% center; }
        100% { background-position: 200% center; }
    }
    .step-line {
        position: absolute;
        left: 23px;
        top: 48px;
        bottom: -48px;
        width: 2px;
        background: linear-gradient(to bottom, #ffb600, rgba(255,182,0,0.1));
    }
    .step-line:last-child { display: none; }
    .glass-card {
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.1);
    }
    .hover-lift {
        transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
    }
    .hover-lift:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12);
    }
</style>

{{-- ==================== HERO CINEMATIC ==================== --}}
<section class="relative overflow-hidden bg-gradient-to-br from-[#23282d] via-[#2c2c2c] to-[#23282d] min-h-[90vh] flex items-center" data-parallax-section>
    {{-- Blobs --}}
    <div class="blob-bg w-[400px] h-[400px] bg-[#ffb600] top-[-100px] right-[-100px]"></div>
    <div class="blob-bg w-[300px] h-[300px] bg-[#ffc009] bottom-[-50px] left-[-50px] animation-delay-2000"></div>
    <div class="blob-bg w-[250px] h-[250px] bg-[#ffb600] top-[40%] left-[20%] animation-delay-4000"></div>

    {{-- Pattern overlay --}}
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #ffb600 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 py-24 lg:py-32">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            {{-- Left: Text --}}
            <div data-reveal="left">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold uppercase tracking-widest text-amber-300 mb-6">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-400"></span>
                    </span>
                    Layanan Mahasiswa
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-7xl font-black text-white leading-[1.05] tracking-tight mb-6">
                    Bimbingan<br>
                    <span class="bg-gradient-to-r from-[#ffb600] via-[#ffc009] to-[#ffb600] bg-clip-text text-transparent">Konseling</span>
                    <br>Karir & Psikologi
                </h1>
                <p class="text-lg sm:text-xl text-slate-300 max-w-lg leading-relaxed mb-8">
                    Temukan arah karirmu. Konseling profesional bersama psikolog dan konselor karier UBB. Gratis untuk seluruh mahasiswa.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('bk.konselor') }}" class="group relative overflow-hidden inline-flex items-center gap-2 px-7 py-3.5 bg-[#ffb600] text-white font-bold rounded-full shadow-lg shadow-[#ffb600]/30 hover:shadow-[#ffb600]/50 transition-all duration-300 hover:scale-[1.03] active:scale-[0.97]">
                        <span>Booking Konseling</span>
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="#tentang" class="inline-flex items-center gap-2 px-7 py-3.5 bg-white/10 backdrop-blur-md border border-white/20 text-white font-medium rounded-full hover:bg-white/20 transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Pelajari
                    </a>
                </div>
                {{-- Trust metrics --}}
                <div class="flex items-center gap-6 mt-10 pt-8 border-t border-white/10">
                    <div>
                        <div class="text-2xl font-bold text-white">{{ $konselors->count() }}+</div>
                        <div class="text-xs text-slate-400">Konselor</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-white">100%</div>
                        <div class="text-xs text-slate-400">Gratis</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-white">Online</div>
                        <div class="text-xs text-slate-400">Zoom/Meet</div>
                    </div>
                </div>
            </div>

            {{-- Right: Visual --}}
            <div class="hidden lg:flex items-center justify-center" data-reveal="right" data-reveal-delay="200">
                <div class="relative w-full max-w-md">
                    {{-- Main glass card --}}
                    <div class="glass-card rounded-3xl p-8 relative">
                        <div class="absolute -top-4 -right-4 w-16 h-16 bg-yellow-500 rounded-2xl rotate-12 flex items-center justify-center shadow-lg shadow-yellow-500/30">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-2xl flex items-center justify-center text-white font-bold text-xl">UP</div>
                            <div>
                                <div class="text-white font-bold">Konseling Karier</div>
                                <div class="text-slate-400 text-sm">Sesi 1-on-1</div>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3 text-sm">
                                <svg class="w-4 h-4 text-yellow-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                <span class="text-slate-300">Psikolog & Konselor Profesional</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm">
                                <svg class="w-4 h-4 text-yellow-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                <span class="text-slate-300">Jadwal Fleksibel</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm">
                                <svg class="w-4 h-4 text-yellow-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                <span class="text-slate-300">Gratis untuk Mahasiswa UBB</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-white/10">
                            <div class="flex -space-x-2">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#ffb600] to-[#ffc009] border-2 border-[#23282d]"></div>
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-300 to-blue-500 border-2 border-[#23282d]"></div>
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-300 to-green-500 border-2 border-[#23282d]"></div>
                            </div>
                            <div class="text-xs text-slate-400 mt-2">+{{ $konselors->count() }} konselor siap membantu</div>
                        </div>
                    </div>
                    {{-- Floating card --}}
                    <div class="absolute -bottom-6 -left-6 glass-card rounded-2xl p-4 hidden sm:block">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-yellow-500/20 flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <div class="text-white text-sm font-semibold">Booking Hari Ini</div>
                                <div class="text-amber-300 text-xs">Sesi tersedia</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10">
        <div class="flex flex-col items-center gap-2 text-slate-500">
            <span class="text-xs tracking-widest uppercase">Scroll</span>
            <div class="w-5 h-8 border-2 border-slate-500 rounded-full flex justify-center">
                <div class="w-1 h-2 bg-slate-400 rounded-full mt-2 animate-bounce"></div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== TENTANG + FEATURE GRID ==================== --}}
<section id="tentang" class="py-24 sm:py-32 bg-white">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-2 gap-16 lg:gap-24 items-center">
            <div data-reveal="left">
                <span class="text-yellow-500 font-bold text-xs tracking-[.2em] uppercase">Tentang Layanan</span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-900 mt-4 mb-6 leading-tight tracking-tight">
                    Arahkan Masa Depanmu<br>
                    <span class="bg-gradient-to-r from-[#ffb600] to-[#ffc009] bg-clip-text text-transparent">Bersama Konselor Ahli</span>
                </h2>
                <p class="text-gray-600 text-base sm:text-lg leading-relaxed max-w-lg">
                    Bimbingan konseling di UPA PKK UBB membantu mahasiswa mengembangkan potensi diri, merencanakan karir, dan mengatasi tantangan akademik maupun personal.
                </p>
                {{-- Stat mini --}}
                <div class="grid grid-cols-3 gap-6 mt-8">
                    <div>
                        <div class="text-3xl font-black text-yellow-500">5+</div>
                        <div class="text-sm text-gray-500">Tahun pengalaman</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-yellow-500">{{ $konselors->count() }}</div>
                        <div class="text-sm text-gray-500">Konselor aktif</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-yellow-500">100%</div>
                        <div class="text-sm text-gray-500">Gratis</div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4" data-stagger>
                @php
                    $features = [
                        ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'label' => 'Konseling Karir', 'desc' => 'Perencanaan karir & pekerjaan'],
                        ['icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'label' => 'Konseling Personal', 'desc' => 'Pengembangan diri & motivasi'],
                        ['icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10', 'label' => 'Psikotes Minat', 'desc' => 'Tes bakat & minat kerja'],
                        ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'label' => 'Persiapan Kerja', 'desc' => 'CV, wawancara & portofolio'],
                    ];
                @endphp
                @foreach($features as $f)
                <div class="group p-5 sm:p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:border-yellow-200 transition-all duration-300 hover:shadow-lg hover:shadow-yellow-500/5 hover:-translate-y-1">
                    <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center mb-3 group-hover:bg-yellow-500 transition-colors duration-300">
                        <svg class="w-5 h-5 text-yellow-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $f['icon'] }}"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-sm sm:text-base">{{ $f['label'] }}</h3>
                    <p class="text-xs text-gray-500 mt-1">{{ $f['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ==================== HOW IT WORKS (Stepper Timeline) ==================== --}}
<section class="py-24 sm:py-32 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="text-center mb-16" data-reveal="up">
            <span class="text-yellow-500 font-bold text-xs tracking-[.2em] uppercase">Alur Konseling</span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-900 mt-4 mb-4 tracking-tight">
                5 Langkah Mudah
            </h2>
            <p class="text-gray-500 text-lg max-w-xl mx-auto">Dari mendaftar hingga sesi konseling, semua mudah dan cepat.</p>
        </div>

        <div class="max-w-3xl mx-auto" data-stagger>
            @php
                $steps = [
                    ['num' => '01', 'title' => 'Pilih Konselor', 'desc' => 'Temukan konselor yang sesuai dengan kebutuhan karir atau personalmu. Lihat profil, spesialisasi, dan pengalaman mereka.'],
                    ['num' => '02', 'title' => 'Pilih Jadwal', 'desc' => 'Pilih hari dan jam yang paling sesuai dengan jadwal kuliahmu. Tersedia slot pagi, siang, dan sore.'],
                    ['num' => '03', 'title' => 'Isi Data & Masalah', 'desc' => 'Lengkapi data diri dan jelaskan secara singkat topik yang ingin kamu konsultasikan. Semua data terjaga kerahasiaannya.'],
                    ['num' => '04', 'title' => 'Konfirmasi & Meeting', 'desc' => 'Dapatkan konfirmasi dan link meeting Zoom/Google Meet. Kamu juga bisa konseling via WhatsApp.'],
                    ['num' => '05', 'title' => 'Konseling & Rating', 'desc' => 'Ikuti sesi konseling dengan nyaman. Setelah selesai, beri rating dan masukan untuk konselor.'],
                ];
            @endphp
            @foreach($steps as $i => $s)
            <div class="relative pl-14 pb-12 last:pb-0">
                <div class="step-line"></div>
                <div class="absolute left-0 top-0 w-12 h-12 bg-yellow-500 rounded-2xl flex items-center justify-center text-white font-black text-sm shadow-lg shadow-yellow-500/20">
                    {{ $s['num'] }}
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">{{ $s['title'] }}</h3>
                    <p class="text-gray-500 mt-1 leading-relaxed">{{ $s['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-12" data-reveal="up">
            <a href="{{ route('bk.konselor') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-[#ffb600] text-white font-bold rounded-full shadow-lg shadow-[#ffb600]/30 hover:shadow-[#ffb600]/50 transition-all duration-300 hover:scale-[1.03] active:scale-[0.97]">
                Mulai Konseling Sekarang
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- ==================== KONSELOR CARD PREMIUM ==================== --}}
<section class="py-24 sm:py-32 bg-white">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between mb-14 gap-6">
            <div data-reveal="left">
                <span class="text-yellow-500 font-bold text-xs tracking-[.2em] uppercase">Konselor</span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-900 mt-4 tracking-tight">
                    Temukan Konselor<br>
                    <span class="bg-gradient-to-r from-[#ffb600] to-[#ffc009] bg-clip-text text-transparent">Terbaik untukmu</span>
                </h2>
            </div>
            <div data-reveal="right">
                <a href="{{ route('bk.konselor') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-yellow-600 font-medium transition-colors group">
                    Lihat Semua Konselor
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" data-stagger>
            @forelse($konselors->take(6) as $k)
            <a href="{{ route('bk.konselor.profil', $k->id) }}" class="group block bg-white rounded-2xl border border-gray-100 hover-lift overflow-hidden">
                <div class="relative h-48 bg-gradient-to-br from-yellow-400 to-amber-500 overflow-hidden">
                    <div class="absolute inset-0 bg-black/10"></div>
                    {{-- Avatar --}}
                    <div class="absolute -bottom-12 left-6">
                        <div class="w-24 h-24 rounded-2xl border-4 border-white overflow-hidden shadow-xl bg-white">
                            @if($k->foto)
                                <img src="{{ asset('storage/' . $k->foto) }}" alt="{{ $k->nama }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-yellow-100 to-amber-100 flex items-center justify-center text-3xl font-black text-yellow-600">{{ substr($k->nama, 0, 1) }}</div>
                            @endif
                        </div>
                    </div>
                    {{-- Badge --}}
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
                            @if($k->jumlah_rating > 0)
                            <span class="text-xs text-gray-600">{{ $k->rating_rata }}</span>
                            <span class="text-xs text-gray-400">({{ $k->jumlah_rating }})</span>
                            @else
                            <span class="text-xs text-gray-400">Belum ada rating</span>
                            @endif
                        </div>
                        <span class="text-xs font-medium text-yellow-600 group-hover:underline">Pilih Jadwal</span>
                    </div>
                </div>
            </a>
            @empty
            <div class="lg:col-span-3 text-center py-16">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <p class="text-gray-500 font-medium">Belum ada konselor tersedia</p>
                <p class="text-sm text-gray-400 mt-1">Silakan cek kembali nanti</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ==================== CTA BOTTOM ==================== --}}
<section class="py-24 sm:py-32 bg-gradient-to-br from-[#23282d] via-[#2c2c2c] to-[#23282d] relative overflow-hidden">
    <div class="blob-bg w-[300px] h-[300px] bg-[#ffb600] top-[-80px] right-[-80px]"></div>
    <div class="blob-bg w-[200px] h-[200px] bg-[#ffc009] bottom-[-50px] left-[-50px]"></div>
    <div class="relative z-10 max-w-4xl mx-auto px-6 sm:px-8 lg:px-12 text-center">
        <div data-reveal="up">
            <span class="text-amber-300 font-bold text-xs tracking-[.2em] uppercase">Siap Memulai?</span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white mt-4 mb-6 leading-tight tracking-tight">
                Konseling Karir Gratis<br>
                <span class="bg-gradient-to-r from-[#ffb600] via-[#ffc009] to-[#ffb600] bg-clip-text text-transparent">Untuk Mahasiswa UBB</span>
            </h2>
            <p class="text-slate-300 text-lg max-w-xl mx-auto mb-8">
                Jadwalkan sesi konselingmu sekarang. Pilih konselor, tentukan jadwal, dan dapatkan bimbingan profesional.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('bk.konselor') }}" class="group inline-flex items-center gap-2 px-8 py-4 bg-[#ffb600] text-white font-bold rounded-full shadow-lg shadow-[#ffb600]/30 hover:shadow-[#ffb600]/50 transition-all duration-300 hover:scale-[1.03] active:scale-[0.97]">
                    Booking Sekarang
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <a href="https://wa.me/6281234567890?text=Halo%20UPA%20PKK%2C%20saya%20ingin%20konseling" target="_blank" class="inline-flex items-center gap-2 px-8 py-4 bg-white/10 backdrop-blur-md border border-white/20 text-white font-medium rounded-full hover:bg-white/20 transition-all duration-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Konseling via WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

