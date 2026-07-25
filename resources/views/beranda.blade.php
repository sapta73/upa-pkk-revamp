@extends('layouts.frontend')

@section('title', 'Beranda | UPA PKK UBB')

@section('content')

<style>
@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
.animated-bg {
    background-size: 200% 200%;
    animation: gradientShift 8s ease infinite;
}
.counter {
    display: inline-block;
}
</style>

{{-- ==================== HERO SLIDER ==================== --}}
<div x-data="heroSlider()" class="relative overflow-hidden" x-init="init()" style="height: 70vh; min-height: 480px;" data-hero>
    <template x-for="(slide, index) in slides" :key="index">
        <div :class="'absolute inset-0 transition-all duration-700 ease-[cubic-bezier(0.4,0,0.2,1)] ' + slidePos(index)">
            <img :src="slide.image" class="absolute inset-0 w-full h-full object-cover object-center" :alt="'Slide ' + (index + 1)">
            <div class="absolute inset-0" :class="slide.overlayDir"></div>
            <div class="relative z-10 flex h-full max-w-7xl mx-auto px-6 sm:px-8 lg:px-12" :class="slide.align">
                <div class="max-w-xl lg:max-w-2xl"
                     :style="slide.slideFrom === 'right' ? '--slide-x:50px' : '--slide-x:-50px'">
                    <template x-if="slide.badge">
                        <div x-show="current === index"
                             x-transition:enter="transition-all duration-500 ease-out delay-[100ms]"
                             x-transition:enter-start="opacity-0 translate-x-[var(--slide-x)]"
                             x-transition:enter-end="opacity-100 translate-x-0"
                             class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold uppercase tracking-wider text-amber-300 mb-5">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-400"></span>
                            </span>
                            <span x-text="slide.badge"></span>
                        </div>
                    </template>
                    <h1 x-show="current === index"
                        x-transition:enter="transition-all duration-500 ease-out delay-[300ms]"
                        x-transition:enter-start="opacity-0 translate-x-[var(--slide-x)]"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-black leading-tight tracking-tight mb-4" x-html="slide.title"></h1>
                    <template x-if="slide.desc">
                        <div x-show="current === index"
                             x-transition:enter="transition-all duration-500 ease-out delay-[500ms]"
                             x-transition:enter-start="opacity-0 translate-x-[var(--slide-x)]"
                             x-transition:enter-end="opacity-100 translate-x-0"
                             class="border-l-4 border-amber-400/80 pl-4 text-slate-200 text-sm md:text-base leading-relaxed mb-6" x-html="slide.desc"></div>
                    </template>
                    <div class="flex flex-wrap gap-3" x-show="slide.buttons && slide.buttons.length">
                        <template x-for="(btn, bIdx) in slide.buttons" :key="bIdx">
                            <a :href="btn.url"
                               :class="btn.variant === 'primary' ? 'bg-yellow-500 hover:bg-yellow-400 text-white font-bold shadow-lg shadow-yellow-500/30' : 'bg-white/20 hover:bg-white/30 text-white border border-white/40'"
                               class="px-6 py-3 text-sm transition-all duration-300 hover:-translate-y-0.5 relative overflow-hidden"
                               data-ripple
                               x-text="btn.text"></a>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </template>
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-2 z-20">
        <template x-for="(slide, index) in slides" :key="index">
            <button @click="goTo(index)"
                    :class="current === index ? 'bg-yellow-500 w-8' : 'bg-white/40 hover:bg-white/70 w-2'"
                    class="h-2 rounded-full transition-all duration-500"></button>
        </template>
    </div>
</div>

{{-- ==================== SECTION 2: TENTANG KAMI ==================== --}}
<section data-section="tentang" class="animated-bg relative overflow-hidden"
     style="background: linear-gradient(135deg, #fef9e7 0%, #ffffff 25%, #fef3c7 50%, #ffffff 75%, #fef9e7 100%); background-size: 200% 200%;">
    <div class="relative z-10 py-20 sm:py-28">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
            <div class="grid lg:grid-cols-2 gap-16 lg:gap-20 items-start">
                <div data-reveal="left">
                    <span class="text-yellow-500 font-bold text-xs tracking-[.2em] uppercase">Tentang Kami</span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-900 mt-3 mb-4 leading-tight tracking-tight" data-reveal="up" data-reveal-delay="100">
                        UPA Pengembangan Karir <br class="hidden sm:block">dan Kewirausahaan
                    </h2>
                    <p class="text-gray-600 text-sm sm:text-base leading-relaxed max-w-xl" data-reveal="up" data-reveal-delay="200">
                        Unit ini didirikan sebagai pusat pengembangan karier dan kewirausahaan mahasiswa dalam menghasilkan lulusan yang mandiri, inovatif, kreatif dan mampu bersaing di pasar kerja.
                    </p>
                    <div class="grid grid-cols-3 gap-3 mt-8" data-stagger data-stagger-delay="120">
                        <div class="text-center p-4 bg-white/80 backdrop-blur rounded-xl border border-yellow-200 hover:shadow-lg hover:shadow-yellow-500/10 hover:-translate-y-1 transition-all duration-300 group" data-reveal="up">
                            <div class="w-12 h-12 mx-auto bg-yellow-100 rounded-lg flex items-center justify-center mb-2 group-hover:bg-yellow-500 transition-colors">
                                <svg class="w-6 h-6 text-yellow-600 group-hover:text-white transition-all duration-300 group-hover:rotate-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" /></svg>
                            </div>
                            <span class="text-xs font-bold text-gray-700 group-hover:text-yellow-600">Dunia Usaha</span>
                        </div>
                        <div class="text-center p-4 bg-white/80 backdrop-blur rounded-xl border border-yellow-200 hover:shadow-lg hover:shadow-yellow-500/10 hover:-translate-y-1 transition-all duration-300 group" data-reveal="up" data-reveal-delay="120">
                            <div class="w-12 h-12 mx-auto bg-yellow-100 rounded-lg flex items-center justify-center mb-2 group-hover:bg-yellow-500 transition-colors">
                                <svg class="w-6 h-6 text-yellow-600 group-hover:text-white transition-all duration-300 group-hover:rotate-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                            </div>
                            <span class="text-xs font-bold text-gray-700 group-hover:text-yellow-600">Dunia Kerja</span>
                        </div>
                        <div class="text-center p-4 bg-white/80 backdrop-blur rounded-xl border border-yellow-200 hover:shadow-lg hover:shadow-yellow-500/10 hover:-translate-y-1 transition-all duration-300 group" data-reveal="up" data-reveal-delay="240">
                            <div class="w-12 h-12 mx-auto bg-yellow-100 rounded-lg flex items-center justify-center mb-2 group-hover:bg-yellow-500 transition-colors">
                                <svg class="w-6 h-6 text-yellow-600 group-hover:text-white transition-all duration-300 group-hover:rotate-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" /></svg>
                            </div>
                            <span class="text-xs font-bold text-gray-700 group-hover:text-yellow-600">Dunia Industri</span>
                        </div>
                    </div>
                </div>
                <div x-data="{ active: null }" x-init="setTimeout(() => active = 1, 300)" data-reveal="right" data-reveal-delay="150">
                    <div class="rounded-xl overflow-hidden border border-gray-200 bg-white/80 backdrop-blur mb-3 transition-all duration-300"
                         :class="active === 1 ? 'ring-2 ring-yellow-500 shadow-lg' : 'hover:shadow-md'">
                        <button @click="active = active === 1 ? null : 1" class="w-full flex items-center justify-between p-5 text-left">
                            <span class="font-bold text-gray-800 text-sm sm:text-base">Layanan Informasi</span>
                            <svg class="w-5 h-5 text-yellow-500 transition-transform duration-400" :class="active === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="active === 1" x-collapse class="px-5 pb-5 text-gray-600 leading-relaxed text-sm">
                            Menyediakan informasi terkini seputar perkembangan karir, lowongan kerja, program kewirausahaan, dan peluang pengembangan diri bagi mahasiswa UBB.
                        </div>
                    </div>
                    <div class="rounded-xl overflow-hidden border border-gray-200 bg-white/80 backdrop-blur mb-3 transition-all duration-300"
                         :class="active === 2 ? 'ring-2 ring-yellow-500 shadow-lg' : 'hover:shadow-md'">
                        <button @click="active = active === 2 ? null : 2" class="w-full flex items-center justify-between p-5 text-left">
                            <span class="font-bold text-gray-800 text-sm sm:text-base">Pengembangan Karir</span>
                            <svg class="w-5 h-5 text-yellow-500 transition-transform duration-400" :class="active === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="active === 2" x-collapse class="px-5 pb-5 text-gray-600 leading-relaxed text-sm">
                            Program pengembangan karir melalui pelatihan soft skill, konseling karir, seminar industri, dan pendampingan memasuki dunia kerja.
                        </div>
                    </div>
                    <div class="rounded-xl overflow-hidden border border-gray-200 bg-white/80 backdrop-blur transition-all duration-300"
                         :class="active === 3 ? 'ring-2 ring-yellow-500 shadow-lg' : 'hover:shadow-md'">
                        <button @click="active = active === 3 ? null : 3" class="w-full flex items-center justify-between p-5 text-left">
                            <span class="font-bold text-gray-800 text-sm sm:text-base">Kewirausahaan</span>
                            <svg class="w-5 h-5 text-yellow-500 transition-transform duration-400" :class="active === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="active === 3" x-collapse class="px-5 pb-5 text-gray-600 leading-relaxed text-sm">
                            Fasilitasi jiwa wirausaha melalui pelatihan bisnis, pendampingan startup, akses permodalan, dan jejaring dengan pelaku usaha sukses.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== SECTION 3: STATISTIK ==================== --}}
<section data-section="statistik" class="bg-gradient-to-r from-yellow-500 to-yellow-600 py-20 sm:py-28 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12" x-data="{ visible: false }" x-intersect="visible = true" data-reveal="scale" data-reveal-once="true">
        <div class="text-center mb-14" x-show="visible" x-transition:enter="transition-all duration-700" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">UPA PKK UBB</h2>
            <p class="text-yellow-100 mt-3 text-lg">Kontribusi nyata untuk civitas akademika UBB</p>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-8">
            <div class="text-center p-6 bg-white/10 backdrop-blur rounded-2xl hover:bg-white/15 transition-all duration-500 group hover:-translate-y-2 hover:shadow-xl hover:shadow-yellow-500/20"
                 x-show="visible" x-transition:enter="transition-all duration-500 delay-100" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                <svg class="w-10 h-10 mx-auto text-white mb-3 group-hover:scale-125 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                <div class="text-3xl sm:text-4xl font-extrabold text-white mt-2" x-data="{ n: 0, t: null }" x-intersect="n = 0; t = setInterval(() => { n >= 328 ? clearInterval(t) : n += 6 }, 30)" x-text="n">0</div>
                <div class="text-sm text-yellow-100 mt-1 font-medium">Dosen</div>
            </div>
            <div class="text-center p-6 bg-white/10 backdrop-blur rounded-2xl hover:bg-white/15 transition-all duration-500 group hover:-translate-y-2 hover:shadow-xl hover:shadow-yellow-500/20"
                 x-show="visible" x-transition:enter="transition-all duration-500 delay-200" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                <svg class="w-10 h-10 mx-auto text-white mb-3 group-hover:scale-125 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                <div class="text-3xl sm:text-4xl font-extrabold text-white mt-2" x-data="{ n: 0, t: null }" x-intersect="n = 0; t = setInterval(() => { n >= 185 ? clearInterval(t) : n += 4 }, 30)" x-text="n">0</div>
                <div class="text-sm text-yellow-100 mt-1 font-medium">Tenaga Pendidik</div>
            </div>
            <div class="text-center p-6 bg-white/10 backdrop-blur rounded-2xl hover:bg-white/15 transition-all duration-500 group hover:-translate-y-2 hover:shadow-xl hover:shadow-yellow-500/20"
                 x-show="visible" x-transition:enter="transition-all duration-500 delay-300" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                <svg class="w-10 h-10 mx-auto text-white mb-3 group-hover:scale-125 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.252a2.25 2.25 0 1 1 0 4.5 2.25 2.25 0 0 1 0-4.5zM12 13.5c-1.596 0-3.12.3-4.5.84V18h9v-3.66a11.94 11.94 0 0 0-4.5-.84z"/></svg>
                <div class="text-3xl sm:text-4xl font-extrabold text-white mt-2" x-data="{ n: 0, t: null }" x-intersect="n = 0; t = setInterval(() => { n >= 10000 ? clearInterval(t) : n += 150 }, 15)" x-text="n.toLocaleString()">0</div>
                <div class="text-sm text-yellow-100 mt-1 font-medium">Mahasiswa</div>
            </div>
            <div class="text-center p-6 bg-white/10 backdrop-blur rounded-2xl hover:bg-white/15 transition-all duration-500 group hover:-translate-y-2 hover:shadow-xl hover:shadow-yellow-500/20"
                 x-show="visible" x-transition:enter="transition-all duration-500 delay-400" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                <svg class="w-10 h-10 mx-auto text-white mb-3 group-hover:scale-125 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18" /></svg>
                <div class="text-3xl sm:text-4xl font-extrabold text-white mt-2" x-data="{ n: 0, t: null }" x-intersect="n = 0; t = setInterval(() => { n >= 11160 ? clearInterval(t) : n += 150 }, 15)" x-text="n.toLocaleString()">0</div>
                <div class="text-sm text-yellow-100 mt-1 font-medium">Alumni</div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== SECTION 4: SAMBUTAN ==================== --}}
<section data-section="sambutan" class="bg-white py-20 sm:py-28">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-5 gap-12 lg:gap-16 items-center">
            <div class="lg:col-span-3" data-reveal="left" data-reveal-delay="100">
                <span class="text-yellow-500 font-bold text-xs tracking-[.2em] uppercase">Kata Sambutan</span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-900 mt-3 mb-6 tracking-tight" data-reveal="up" data-reveal-delay="200">Sambutan Kepala UPA PKK</h2>
                <div class="text-gray-600 leading-relaxed space-y-4 text-sm sm:text-base" data-reveal="up" data-reveal-delay="350">
                    <p>Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>
                    <p>Salam sejahtera bagi kita semua.</p>
                    <p>Sebagai Kepala Unit Penunjang Akademik Pengembangan Karir dan Kewirausahaan Universitas Bangka Belitung, saya mengucapkan terima kasih atas dukungan dan kepercayaan yang diberikan. Unit kami berfokus pada peningkatan kemampuan mahasiswa dalam pengembangan karier dan kewirausahaan melalui berbagai program pelatihan, seminar, serta kerja sama dengan mitra industri. Kami berkomitmen untuk mempersiapkan mahasiswa agar lebih siap menghadapi tantangan dunia kerja serta memberikan fasilitas untuk mengembangkan jiwa kewirausahaan.</p>
                    <p>Kami juga menyediakan layanan informasi dan jejaring yang relevan agar mahasiswa dapat mengakses berbagai peluang pengembangan karier dan usaha. Semoga upaya ini dapat mendukung kesuksesan mahasiswa Universitas Bangka Belitung dalam meraih masa depan yang gemilang. Terima kasih.</p>
                    <p>Wassalamu'alaikum Warahmatullahi Wabarakatuh.</p>
                </div>
            </div>
            <div class="lg:col-span-2 text-center" data-reveal="right" data-reveal-delay="150">
                <div class="relative inline-block group">
                    <div class="absolute -inset-3 bg-gradient-to-br from-yellow-400 via-yellow-500 to-yellow-600 rounded-3xl blur-lg opacity-30 group-hover:opacity-60 transition-all duration-700 group-hover:scale-105"></div>
                    <div class="relative bg-white p-2 rounded-2xl shadow-xl overflow-hidden">
                        <img src="{{ asset('img/kepala.png') }}" alt="Kepala UPA PKK" class="w-full max-w-xs mx-auto rounded-xl transform group-hover:scale-105 transition-transform duration-700 float-slow">
                    </div>
                    <div class="mt-4 text-center">
                        <h3 class="font-extrabold text-gray-900 text-lg tracking-tight">Dr. Eni Karsiningsih, M.Si.</h3>
                        <p class="text-sm text-yellow-500 font-bold mt-0.5">Kepala UPA PKK UBB</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== SECTION 5: BERITA ==================== --}}
<section data-section="berita" class="bg-gray-50 py-20 sm:py-28">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 text-center" data-reveal="up">
        <span class="text-yellow-500 font-bold text-xs tracking-[.2em] uppercase" data-reveal="up" data-reveal-delay="100">Informasi</span>
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-900 mt-3 mb-4 tracking-tight" data-reveal="up" data-reveal-delay="200">Berita Terbaru</h2>
        <p class="text-gray-600 text-base sm:text-lg max-w-xl mx-auto" data-reveal="up" data-reveal-delay="300">Informasi terkini seputar kegiatan dan program UPA PKK UBB</p>
    </div>
</section>

<script>
function heroSlider() {
    return {
        current: 0,
        prev: -1,
        animating: false,
        interval: null,
        slides: [
            {
                image: '{{ asset("images/slider-main/01.png") }}',
                badge: 'Unit Penunjang Akademik',
                title: '<span class="bg-gradient-to-r from-yellow-300 via-amber-400 to-yellow-500 bg-clip-text text-transparent">PENGEMBANGAN KARIR</span> &<br><span class="bg-gradient-to-r from-yellow-300 via-amber-400 to-yellow-500 bg-clip-text text-transparent">KEWIRAUSAHAAN</span>',
                desc: 'Mempersiapkan mahasiswa UBB menghadapi dunia kerja dan kewirausahaan secara profesional.',
                align: 'items-center text-left',
                overlayDir: 'bg-gradient-to-r from-black/40 via-black/20 to-transparent',
                slideFrom: 'left',
                buttons: [
                    { text: 'Karir', url: '/karir', variant: 'primary' },
                    { text: 'Bimbingan Konseling', url: '/bimbingan-konseling', variant: 'primary' },
                    { text: 'Kewirausahaan', url: '/kewirausahaan', variant: 'secondary' }
                ]
            },
            {
                image: '{{ asset("images/slider-main/3.png") }}',
                badge: 'PENINGKATAN',
                title: '<span class="bg-gradient-to-r from-yellow-300 via-amber-400 to-yellow-500 bg-clip-text text-transparent font-black drop-shadow-lg">KEMAMPUAN</span> <span class="bg-gradient-to-r from-yellow-300 via-amber-400 to-yellow-500 bg-clip-text text-transparent font-black drop-shadow-[0_0_15px_rgba(251,191,36,0.5)]">MAHASISWA</span>',
                desc: 'Di bidang <span class="px-2 py-0.5 rounded bg-amber-400/20 text-amber-300 font-semibold border border-amber-400/30">Karir</span> dan <span class="px-2 py-0.5 rounded bg-amber-400/20 text-amber-300 font-semibold border border-amber-400/30">Kewirausahaan</span> berdaya saing global',
                align: 'items-center text-left',
                overlayDir: 'bg-gradient-to-r from-black/30 via-black/10 to-transparent',
                slideFrom: 'left',
                buttons: [
                    { text: 'Selengkapnya', url: '/profil/visi-misi', variant: 'primary' }
                ]
            },
            {
                image: '{{ asset("images/slider-main/03.png") }}',
                badge: 'FASILITAS & KERJA SAMA',
                title: '<span class="bg-gradient-to-r from-yellow-300 via-amber-400 to-yellow-500 bg-clip-text text-transparent font-black drop-shadow-md">PENGEMBANGAN <span class="drop-shadow-[0_0_12px_rgba(251,191,36,0.6)]">KARIR</span> DAN <span class="drop-shadow-[0_0_12px_rgba(251,191,36,0.6)]">KEWIRAUSAHAAN</span></span>',
                desc: 'Bersama mitra industri dan institusi terpercaya membangun masa depan mahasiswa.',
                align: 'items-center justify-end text-right',
                overlayDir: 'bg-gradient-to-l from-black/40 via-black/20 to-transparent',
                slideFrom: 'right'
            }
        ],
        slidePos(index) {
            if (index === this.current) return 'translate-x-0 z-10';
            if (index === this.prev) return '-translate-x-full z-10';
            return 'translate-x-full';
        },
        nextSlide() {
            if (this.animating) return;
            this.animating = true;
            this.prev = this.current;
            this.current = (this.current + 1) % this.slides.length;
            setTimeout(() => {
                this.prev = -1;
                this.animating = false;
            }, 700);
        },
        goTo(index) {
            if (this.animating || index === this.current) return;
            this.animating = true;
            this.prev = this.current;
            this.current = index;
            setTimeout(() => {
                this.prev = -1;
                this.animating = false;
            }, 700);
        },
        init() {
            this.interval = setInterval(() => this.nextSlide(), 5500);
        }
    };
}
</script>
@endsection
