<style>
    :root {
        --nav-ease: cubic-bezier(0.4, 0, 0.2, 1);
    }

    .nav-link {
        position: relative;
        transition: color 0.25s var(--nav-ease), transform 0.25s var(--nav-ease);
        transform: translateY(0);
    }
    .nav-link::after {
        content: '';
        position: absolute;
        bottom: 4px;
        left: 50%;
        width: 0;
        height: 2px;
        background: #eab308;
        border-radius: 2px;
        transition: width 0.3s var(--nav-ease), left 0.3s var(--nav-ease);
    }
    .nav-link:hover {
        color: #ca8a04;
        transform: translateY(-2px);
    }
    .nav-link:hover::after {
        width: 60%;
        left: 20%;
    }

    .nav-link-active {
        background: rgba(234, 179, 8, 0.12);
        color: #a16207;
        box-shadow: 0 1px 3px rgba(234, 179, 8, 0.15);
    }

    .dropdown-menu {
        transform-origin: top center;
        animation: dropdownIn 0.25s var(--nav-ease) forwards;
    }
    @keyframes dropdownIn {
        0% { opacity: 0; transform: translateY(-6px) scale(0.96); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    .dropdown-item {
        position: relative;
        transition: all 0.2s var(--nav-ease);
        padding-left: 1rem;
    }
    .dropdown-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 3px;
        height: 0;
        background: #eab308;
        border-radius: 0 2px 2px 0;
        transition: height 0.25s var(--nav-ease), top 0.25s var(--nav-ease);
    }
    .dropdown-item:hover::before {
        height: 60%;
        top: 20%;
    }
    .dropdown-item:hover {
        background: rgba(234, 179, 8, 0.08);
        color: #a16207;
        padding-left: 1.25rem;
    }

    .cta-btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s var(--nav-ease);
    }
    .cta-btn::after {
        content: '';
        position: absolute;
        inset: -2px;
        border-radius: 9999px;
        background: conic-gradient(from 0deg, transparent, rgba(234,179,8,0.4), transparent, rgba(234,179,8,0.4), transparent);
        opacity: 0;
        transition: opacity 0.4s var(--nav-ease);
        z-index: -1;
    }
    .cta-btn:hover {
        transform: scale(1.03);
        box-shadow: 0 4px 20px rgba(234, 179, 8, 0.35);
    }
    .cta-btn:hover::after {
        opacity: 1;
        animation: ctaGlow 2s linear infinite;
    }
    .cta-btn:active {
        transform: scale(0.97);
    }
    @keyframes ctaGlow {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .ripple {
        position: relative;
        overflow: hidden;
    }
    .ripple::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        width: 100px;
        height: 100px;
        margin-top: -50px;
        margin-left: -50px;
        top: 50%;
        left: 50%;
        transform: scale(0);
        opacity: 0;
    }
    .ripple:active::after {
        animation: rippleAnim 0.5s ease-out forwards;
    }
    @keyframes rippleAnim {
        0% { transform: scale(0); opacity: 0.5; }
        100% { transform: scale(3); opacity: 0; }
    }

    .nav-scrolled {
        background: rgba(255, 255, 255, 0.92) !important;
        backdrop-filter: blur(16px) saturate(180%);
        -webkit-backdrop-filter: blur(16px) saturate(180%);
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    }

    .hamburger-line {
        transition: all 0.3s var(--nav-ease);
        transform-origin: center;
    }

    @media (max-width: 767px) {
        .mobile-nav {
            animation: mobileSlideIn 0.3s var(--nav-ease) forwards;
        }
        @keyframes mobileSlideIn {
            0% { opacity: 0; transform: translateY(-8px) scale(0.98); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
    }

    /* keyboard focus */
    .focus-ring:focus-visible {
        outline: 2px solid #eab308;
        outline-offset: 2px;
        border-radius: 8px;
    }
</style>

<nav x-data="navbarNav()"
     x-init="init()"
     @scroll.window="onScroll()"
     class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
     :class="scrolled ? 'nav-scrolled' : 'bg-transparent'"
     style="background: rgba(255,255,255,0.85); backdrop-filter: blur(12px) saturate(180%); -webkit-backdrop-filter: blur(12px) saturate(180%);">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 transition-all duration-300"
         :class="scrolled ? 'py-2' : 'py-3 lg:py-4'">

        <div class="flex items-center justify-between">
            {{-- LOGO --}}
            <a href="{{ url('/') }}" class="flex items-center shrink-0 group focus-ring" aria-label="Beranda UPA PKK UBB">
                <img src="{{ asset('img/UPA. PKK.png') }}" alt="UPA PKK UBB"
                     class="transition-all duration-300"
                     :class="scrolled ? 'h-9 lg:h-10' : 'h-10 lg:h-12'"
                     style="width: auto;">
            </a>

            {{-- DESKTOP MENU --}}
            <div class="hidden md:flex items-center gap-1 lg:gap-1.5">
                <a href="{{ url('/') }}"
                   class="nav-link px-3 lg:px-4 py-2 text-sm font-medium text-gray-700 rounded-lg focus-ring"
                   :class="isActive('/') ? 'nav-link-active' : ''">Beranda</a>

                {{-- DROPDOWN PROFIL --}}
                <div class="relative" x-data="{ profilOpen: false }">
                    <button @click="profilOpen = !profilOpen" @click.away="profilOpen = false"
                            class="nav-link px-3 lg:px-4 py-2 text-sm font-medium text-gray-700 rounded-lg flex items-center gap-1.5 focus-ring"
                            :class="isActive('/profil') ? 'nav-link-active' : ''">
                        Profil
                        <svg class="w-3.5 h-3.5 transition-transform duration-250" :class="profilOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="profilOpen"
                         x-cloak
                         class="dropdown-menu absolute left-0 mt-2 w-52 bg-white/90 backdrop-blur-xl rounded-2xl shadow-lg shadow-black/5 border border-gray-100/80 py-2 z-50">
                        <a href="{{ url('/profil/visi-misi') }}" class="dropdown-item block py-2.5 text-sm text-gray-600">Visi Misi</a>
                        <a href="{{ url('/profil/struktur') }}" class="dropdown-item block py-2.5 text-sm text-gray-600">Struktur Organisasi</a>
                        <a href="{{ url('/profil/tugas-fungsi') }}" class="dropdown-item block py-2.5 text-sm text-gray-600">Tugas Fungsi</a>
                    </div>
                </div>

                {{-- DROPDOWN INFORMASI --}}
                <div class="relative" x-data="{ infoOpen: false }">
                    <button @click="infoOpen = !infoOpen" @click.away="infoOpen = false"
                            class="nav-link px-3 lg:px-4 py-2 text-sm font-medium text-gray-700 rounded-lg flex items-center gap-1.5 focus-ring"
                            :class="isActive('/berita') || isActive('/pengumuman') ? 'nav-link-active' : ''">
                        Informasi
                        <svg class="w-3.5 h-3.5 transition-transform duration-250" :class="infoOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="infoOpen"
                         x-cloak
                         class="dropdown-menu absolute left-0 mt-2 w-52 bg-white/90 backdrop-blur-xl rounded-2xl shadow-lg shadow-black/5 border border-gray-100/80 py-2 z-50">
                        <a href="{{ url('/berita') }}" class="dropdown-item block py-2.5 text-sm text-gray-600">Berita</a>
                        <a href="{{ url('/pengumuman') }}" class="dropdown-item block py-2.5 text-sm text-gray-600">Pengumuman</a>
                    </div>
                </div>

                <a href="{{ url('/ppid') }}" class="nav-link px-3 lg:px-4 py-2 text-sm font-medium text-gray-700 rounded-lg focus-ring"
                   :class="isActive('/ppid') ? 'nav-link-active' : ''">PPID</a>
                <a href="{{ route('karier.index') }}" class="nav-link px-3 lg:px-4 py-2 text-sm font-medium text-gray-700 rounded-lg focus-ring"
                   :class="isActive('/karier') || isActive('/lowongan-kerja') ? 'nav-link-active' : ''">Karir</a>

                <a href="{{ route('wirausaha.landing') }}" class="nav-link px-3 lg:px-4 py-2 text-sm font-medium text-gray-700 rounded-lg focus-ring"
                   :class="isActive('/wirausaha') ? 'nav-link-active' : ''">Wirausaha</a>
                <a href="{{ url('/bimbingan-konseling') }}" class="nav-link px-3 lg:px-4 py-2 text-sm font-medium text-gray-700 rounded-lg focus-ring"
                   :class="isActive('/bimbingan-konseling') ? 'nav-link-active' : ''">BK</a>
                <a href="{{ url('/kontak') }}" class="nav-link px-3 lg:px-4 py-2 text-sm font-medium text-gray-700 rounded-lg focus-ring"
                   :class="isActive('/kontak') ? 'nav-link-active' : ''">Kontak</a>
            </div>

            {{-- RIGHT SECTION --}}
            <div class="flex items-center gap-2 lg:gap-3">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ url('/admin') }}" class="hidden sm:inline-flex cta-btn items-center px-5 py-2 text-xs font-bold bg-gradient-to-r from-yellow-500 to-amber-500 text-white rounded-full shadow-lg shadow-yellow-500/20 focus-ring">Admin</a>
                    @elseif(auth()->user()->role === 'mahasiswa')
                        <a href="{{ url('/mahasiswa/my-booking') }}" class="hidden sm:inline-flex cta-btn items-center px-5 py-2 text-xs font-bold bg-gradient-to-r from-yellow-500 to-amber-500 text-white rounded-full shadow-lg shadow-yellow-500/20 focus-ring">Dashboard</a>
                    @elseif(auth()->user()->role === 'konselor')
                        <a href="{{ url('/konselor/dashboard') }}" class="hidden sm:inline-flex cta-btn items-center px-5 py-2 text-xs font-bold bg-gradient-to-r from-yellow-500 to-amber-500 text-white rounded-full shadow-lg shadow-yellow-500/20 focus-ring">Dashboard</a>
                    @endif

                    <div class="relative hidden sm:block" x-data="{ akunOpen: false }">
                        <button type="button" @click="akunOpen = !akunOpen" @click.away="akunOpen = false"
                                class="flex items-center gap-2 rounded-full border border-gray-200 bg-white/80 px-2 py-1.5 text-xs font-semibold text-[#303030] hover:border-[#ffb600] transition focus-ring"
                                aria-haspopup="true" :aria-expanded="akunOpen.toString()">
                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#fff4d6] text-[11px] font-extrabold text-[#303030]">
                                {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                            </span>
                            <span class="max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                            <svg class="w-3.5 h-3.5 text-gray-400 transition-transform duration-200" :class="akunOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="akunOpen" x-cloak class="dropdown-menu absolute right-0 mt-2 w-60 bg-white/95 backdrop-blur-xl rounded-2xl shadow-lg shadow-black/5 border border-gray-100/80 py-2 z-50">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-[#303030] truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('profil.edit') }}" class="dropdown-item block px-4 py-2.5 text-sm text-gray-600">Profil Saya</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-[#c0343d] hover:bg-red-50 transition">Keluar</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex cta-btn items-center gap-2 px-5 py-2.5 text-sm font-bold bg-gradient-to-r from-yellow-500 to-amber-500 text-white rounded-full shadow-lg shadow-yellow-500/20 focus-ring">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        Masuk
                    </a>
                @endauth

                {{-- HAMBURGER --}}
                <button @click="mobileOpen = !mobileOpen"
                        class="md:hidden relative w-10 h-10 flex items-center justify-center rounded-xl text-gray-600 hover:text-yellow-600 hover:bg-yellow-50 transition-all duration-250 focus-ring"
                        aria-label="Toggle menu">
                    <span class="sr-only">Menu</span>
                    <span class="flex flex-col gap-1.5">
                        <span class="hamburger-line block w-5 h-0.5 bg-current rounded-full"
                              :class="mobileOpen ? 'rotate-45 translate-y-[7px]' : ''"></span>
                        <span class="hamburger-line block w-5 h-0.5 bg-current rounded-full"
                              :class="mobileOpen ? 'opacity-0 scale-x-0' : ''"></span>
                        <span class="hamburger-line block w-5 h-0.5 bg-current rounded-full"
                              :class="mobileOpen ? '-rotate-45 -translate-y-[7px]' : ''"></span>
                    </span>
                </button>
            </div>
        </div>

        {{-- MOBILE MENU --}}
        <div x-show="mobileOpen"
             x-cloak
             x-transition:enter="transition-all duration-300 ease-out"
             x-transition:enter-start="opacity-0 -translate-y-3 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             class="md:hidden border-t border-gray-100/80 mt-2 pt-3 pb-4 mobile-nav">
            <div class="space-y-0.5">
                <a href="{{ url('/') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-yellow-600 hover:bg-yellow-50/80 rounded-xl transition-all duration-200 focus-ring">Beranda</a>
                <div x-data="{ mProfil: false }">
                    <button @click="mProfil = !mProfil" class="w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:text-yellow-600 hover:bg-yellow-50/80 rounded-xl transition-all duration-200 focus-ring">
                        Profil
                        <svg class="w-3.5 h-3.5 transition-transform duration-250" :class="mProfil ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="mProfil" x-collapse class="ml-4 space-y-0.5">
                        <a href="{{ url('/profil/visi-misi') }}" class="block px-4 py-2 text-sm text-gray-500 hover:text-yellow-600 hover:bg-yellow-50/80 rounded-xl transition-all duration-200 focus-ring">Visi Misi</a>
                        <a href="{{ url('/profil/struktur') }}" class="block px-4 py-2 text-sm text-gray-500 hover:text-yellow-600 hover:bg-yellow-50/80 rounded-xl transition-all duration-200 focus-ring">Struktur Organisasi</a>
                        <a href="{{ url('/profil/tugas-fungsi') }}" class="block px-4 py-2 text-sm text-gray-500 hover:text-yellow-600 hover:bg-yellow-50/80 rounded-xl transition-all duration-200 focus-ring">Tugas Fungsi</a>
                    </div>
                </div>
                <div x-data="{ mInfo: false }">
                    <button @click="mInfo = !mInfo" class="w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 hover:text-yellow-600 hover:bg-yellow-50/80 rounded-xl transition-all duration-200 focus-ring">
                        Informasi
                        <svg class="w-3.5 h-3.5 transition-transform duration-250" :class="mInfo ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="mInfo" x-collapse class="ml-4 space-y-0.5">
                        <a href="{{ url('/berita') }}" class="block px-4 py-2 text-sm text-gray-500 hover:text-yellow-600 hover:bg-yellow-50/80 rounded-xl transition-all duration-200 focus-ring">Berita</a>
                        <a href="{{ url('/pengumuman') }}" class="block px-4 py-2 text-sm text-gray-500 hover:text-yellow-600 hover:bg-yellow-50/80 rounded-xl transition-all duration-200 focus-ring">Pengumuman</a>
                    </div>
                </div>
                <a href="{{ url('/ppid') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-yellow-600 hover:bg-yellow-50/80 rounded-xl transition-all duration-200 focus-ring">PPID</a>
                <a href="{{ route('karier.index') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-yellow-600 hover:bg-yellow-50/80 rounded-xl transition-all duration-200 focus-ring">Karir</a>
                <a href="{{ route('wirausaha.landing') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-yellow-600 hover:bg-yellow-50/80 rounded-xl transition-all duration-200 focus-ring">Wirausaha</a>
                <a href="{{ url('/bimbingan-konseling') }}" class="block px-4 py-2.5 text-sm font-semibold text-yellow-600 hover:bg-yellow-50/80 rounded-xl transition-all duration-200 focus-ring">Bimbingan Konseling</a>
                <a href="{{ url('/kontak') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-yellow-600 hover:bg-yellow-50/80 rounded-xl transition-all duration-200 focus-ring">Kontak</a>
            </div>

            @auth
                <hr class="my-3 border-gray-100">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ url('/admin') }}" class="block px-4 py-2.5 text-sm font-semibold text-yellow-600 hover:bg-yellow-50/80 rounded-xl transition-all duration-200 focus-ring">Panel Admin</a>
                @elseif(auth()->user()->role === 'mahasiswa')
                    <a href="{{ url('/mahasiswa/my-booking') }}" class="block px-4 py-2.5 text-sm font-semibold text-yellow-600 hover:bg-yellow-50/80 rounded-xl transition-all duration-200 focus-ring">Dashboard Mahasiswa</a>
                @elseif(auth()->user()->role === 'konselor')
                    <a href="{{ url('/konselor/dashboard') }}" class="block px-4 py-2.5 text-sm font-semibold text-yellow-600 hover:bg-yellow-50/80 rounded-xl transition-all duration-200 focus-ring">Dashboard Konselor</a>
                @endif
                <a href="{{ route('profil.edit') }}" class="block px-4 py-2.5 text-sm font-semibold text-[#303030] hover:bg-yellow-50/80 rounded-xl transition-all duration-200 focus-ring">Profil Saya</a>
                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-500 hover:bg-red-50/80 rounded-xl transition-all duration-200 focus-ring">Keluar</button>
                </form>
            @else
                <hr class="my-3 border-gray-100">
                <a href="{{ route('login') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-yellow-600 hover:bg-yellow-50/80 rounded-xl transition-all duration-200 focus-ring">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="block px-4 py-2.5 text-sm text-gray-600 hover:text-yellow-600 hover:bg-yellow-50/80 rounded-xl transition-all duration-200 focus-ring">Daftar</a>
            @endauth
        </div>
    </div>
</nav>

<script>
function navbarNav() {
    return {
        scrolled: false,
        mobileOpen: false,
        onScroll() {
            this.scrolled = window.scrollY > 20;
        },
        isActive(path) {
            if (typeof window === 'undefined') return false;
            const current = window.location.pathname;
            if (path === '/') return current === '/';
            return current.startsWith(path);
        },
        init() {
            this.scrolled = window.scrollY > 20;
        }
    };
}
</script>
