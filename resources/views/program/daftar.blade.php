@extends('layouts.frontend')

@section('title', 'Pendaftaran Program | UPA PKK UBB')

@section('content')
<section class="relative overflow-hidden bg-gradient-to-br from-[#23282d] via-[#2c2c2c] to-[#23282d] py-20 lg:py-24">
    <div class="absolute w-[250px] h-[250px] bg-[#ffb600]/10 rounded-full blur-[100px] top-[-50px] right-[-50px]"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <a href="{{ route('wirausaha.landing') }}" class="inline-flex items-center gap-2 text-white/60 hover:text-white mb-6 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
            <span class="text-sm">Kembali ke Wirausaha</span>
        </a>
        <h1 class="text-3xl lg:text-5xl font-black text-white tracking-tight">Pendaftaran Program Mahasiswa</h1>
        <p class="text-white/70 text-base lg:text-lg mt-4 max-w-2xl leading-relaxed">Daftar program PMW, P2MW, dan KLK. Isi data tim dan tautkan proposal usaha Anda.</p>
    </div>
</section>

<section class="py-12 lg:py-16 bg-gray-50">
    <div class="max-w-5xl mx-auto px-6 sm:px-8 lg:px-12">
        @if(session('sukses'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('sukses') }}</div>
        @endif
        @if(session('gagal'))
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('gagal') }}</div>
        @endif

        @if($pendaftaran->isNotEmpty())
            <div class="grid sm:grid-cols-3 gap-4 mb-8">
                @foreach(['pmw' => 'PMW', 'p2mw' => 'P2MW', 'klk' => 'KLK'] as $kode => $label)
                    @if($pendaftaran->has($kode))
                        @php $item = $pendaftaran->get($kode); @endphp
                        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-500">{{ $label }}</p>
                            <p class="mt-2 text-sm font-semibold text-[#252525]">{{ $item->nama_tim }}</p>
                            <span class="mt-2 inline-flex rounded-full px-2.5 py-1 text-xs font-bold {{ $item->status === 'diterima' ? 'bg-green-100 text-green-700' : ($item->status === 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">{{ $item->label_status }}</span>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-gray-100 p-6 lg:p-8 shadow-sm">
            <h2 class="text-xl font-bold text-[#252525]">Form Pendaftaran</h2>
            <p class="text-sm text-gray-500 mt-1 mb-6">Satu pendaftaran untuk setiap program. Pastikan data tim dan link proposal valid.</p>

            <form method="post" action="{{ route('wirausaha.program.store') }}" class="space-y-5">
                @csrf

                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label for="program" class="block text-sm font-semibold text-[#303030] mb-1.5">Program</label>
                        <select id="program" name="program" required class="w-full rounded-xl border-gray-300 text-sm focus:border-[#ffb600] focus:ring-[#ffb600]">
                            <option value="">Pilih Program</option>
                            <option value="pmw" @selected(old('program') === 'pmw')>PMW</option>
                            <option value="p2mw" @selected(old('program') === 'p2mw')>P2MW</option>
                            <option value="klk" @selected(old('program') === 'klk')>KLK</option>
                        </select>
                        @error('program') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="nama_tim" class="block text-sm font-semibold text-[#303030] mb-1.5">Nama Tim</label>
                        <input id="nama_tim" name="nama_tim" type="text" value="{{ old('nama_tim') }}" required class="w-full rounded-xl border-gray-300 text-sm focus:border-[#ffb600] focus:ring-[#ffb600]">
                        @error('nama_tim') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="ketua" class="block text-sm font-semibold text-[#303030] mb-1.5">Ketua Tim</label>
                        <input id="ketua" name="ketua" type="text" value="{{ old('ketua', auth()->user()->name) }}" required class="w-full rounded-xl border-gray-300 text-sm focus:border-[#ffb600] focus:ring-[#ffb600]">
                        @error('ketua') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="judul_usaha" class="block text-sm font-semibold text-[#303030] mb-1.5">Judul Usaha</label>
                        <input id="judul_usaha" name="judul_usaha" type="text" value="{{ old('judul_usaha') }}" required class="w-full rounded-xl border-gray-300 text-sm focus:border-[#ffb600] focus:ring-[#ffb600]">
                        @error('judul_usaha') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="anggota" class="block text-sm font-semibold text-[#303030] mb-1.5">Anggota Tim</label>
                    <textarea id="anggota" name="anggota" rows="4" class="w-full rounded-xl border-gray-300 text-sm focus:border-[#ffb600] focus:ring-[#ffb600]" placeholder="Satu nama per baris">{{ old('anggota') }}</textarea>
                    @error('anggota') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-semibold text-[#303030] mb-1.5">Deskripsi Usaha</label>
                    <textarea id="deskripsi" name="deskripsi" rows="5" required class="w-full rounded-xl border-gray-300 text-sm focus:border-[#ffb600] focus:ring-[#ffb600]" placeholder="Jelaskan ide, produk, dan target pasar usaha">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="link_proposal" class="block text-sm font-semibold text-[#303030] mb-1.5">Link Proposal</label>
                    <input id="link_proposal" name="link_proposal" type="url" value="{{ old('link_proposal') }}" required class="w-full rounded-xl border-gray-300 text-sm focus:border-[#ffb600] focus:ring-[#ffb600]" placeholder="https://drive.google.com/...">
                    @error('link_proposal') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#ffb600] px-6 py-3 text-sm font-bold text-[#252525] shadow-sm hover:bg-[#e6a400] transition">Kirim Pendaftaran</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
