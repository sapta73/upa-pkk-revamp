@extends('layouts.akun')

@section('judul', 'Akun Saya | UPA PKK UBB')

@section('konten')
    @php
        $labelRole = match ($pengguna->role) {
            'admin' => 'Admin',
            'konselor' => 'Konselor',
            'dosen' => 'Dosen',
            'tendik' => 'Tendik',
            default => 'Mahasiswa',
        };
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">
        <div class="mb-8">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#b45309]">Pengaturan Akun</p>
            <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-[#303030]">Akun Saya</h1>
            <p class="mt-2 text-sm text-gray-600 max-w-2xl">Kelola data pribadi, keamanan, dan akses akun Anda.</p>
        </div>

        @if (session('status') === 'profil-diperbarui')
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                Data profil berhasil diperbarui.
            </div>
        @endif

        <div class="grid lg:grid-cols-[300px_minmax(0,1fr)] gap-8 items-start">
            <aside class="space-y-4 lg:sticky lg:top-24">
                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                    <div class="h-16 w-16 rounded-full bg-[#fff4d6] text-[#303030] flex items-center justify-center text-xl font-extrabold">
                        {{ strtoupper(mb_substr($pengguna->name, 0, 1)) }}
                    </div>
                    <h2 class="mt-4 text-lg font-bold text-[#252525]">{{ $pengguna->name }}</h2>
                    <p class="text-sm text-gray-500 break-all">{{ $pengguna->email }}</p>
                    <span class="mt-3 inline-flex items-center rounded-full bg-[#fff4d6] px-3 py-1 text-xs font-semibold text-[#303030]">
                        {{ $labelRole }}
                    </span>

                    @if ($pengguna->role === 'mahasiswa')
                        <dl class="mt-5 space-y-2 text-sm">
                            <div class="flex justify-between gap-3">
                                <dt class="text-gray-500">NIM</dt>
                                <dd class="font-medium text-right text-[#303030]">{{ $pengguna->nim ?: '-' }}</dd>
                            </div>
                            <div class="flex justify-between gap-3">
                                <dt class="text-gray-500">Prodi</dt>
                                <dd class="font-medium text-right text-[#303030]">{{ $pengguna->prodi ?: '-' }}</dd>
                            </div>
                        </dl>
                    @elseif ($pengguna->role === 'konselor')
                        <dl class="mt-5 space-y-2 text-sm">
                            <div class="flex justify-between gap-3">
                                <dt class="text-gray-500">Nomor HP</dt>
                                <dd class="font-medium text-right text-[#303030]">{{ $pengguna->nomor_hp ?: '-' }}</dd>
                            </div>
                        </dl>
                    @elseif (in_array($pengguna->role, ['dosen', 'tendik']))
                        <dl class="mt-5 space-y-2 text-sm">
                            <div class="flex justify-between gap-3">
                                <dt class="text-gray-500">NIP</dt>
                                <dd class="font-medium text-right text-[#303030]">{{ $pengguna->nip ?: '-' }}</dd>
                            </div>
                            <div class="flex justify-between gap-3">
                                <dt class="text-gray-500">Unit</dt>
                                <dd class="font-medium text-right text-[#303030]">{{ $pengguna->unit ?: '-' }}</dd>
                            </div>
                        </dl>
                    @endif
                </div>

                <nav class="bg-white border border-gray-200 rounded-2xl p-2 shadow-sm text-sm">
                    <a href="#data-diri" class="block px-4 py-2.5 rounded-xl font-semibold text-[#303030] border-l-4 border-[#ffb600] bg-[#fff9e8]">Data Diri</a>
                    <a href="#keamanan" class="block px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 transition">Keamanan</a>
                    @if ($pengguna->role === 'mahasiswa')
                        <a href="#hapus-akun" class="block px-4 py-2.5 rounded-xl text-[#c0343d] hover:bg-red-50 transition">Hapus Akun</a>
                    @endif
                </nav>
            </aside>

            <div class="space-y-6">
                @include('profil.partials.data-diri')
                @include('profil.partials.kata-sandi')
                @if ($pengguna->role === 'mahasiswa')
                    @include('profil.partials.hapus-akun')
                @endif
            </div>
        </div>
    </div>
@endsection
