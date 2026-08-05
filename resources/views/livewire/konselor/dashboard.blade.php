<div>
    <div class="max-w-7xl mx-auto px-4 py-10 lg:py-16">

        {{-- Header --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-10" data-reveal="up">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#ffb600] to-[#ffc009] flex items-center justify-center text-white font-black text-2xl shrink-0">
                    {{ substr($konselor->nama, 0, 1) }}
                </div>
                <div>
                    <p class="text-yellow-600 text-xs font-bold uppercase tracking-widest">Dashboard Konselor</p>
                    <h1 class="text-2xl lg:text-3xl font-black text-gray-900">{{ $konselor->nama }}</h1>
                    <p class="text-sm text-gray-500">{{ $konselor->spesialisasi }}</p>
                </div>
            </div>
            <a href="{{ route('bk.konselor.profil', $konselor->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#ffb600] text-white font-bold rounded-xl hover:bg-[#e6a400] transition-all duration-300 shadow-lg shadow-[#ffb600]/30 w-fit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Lihat Profil Saya
            </a>
        </div>

        {{-- Alert Sukses --}}
        @if(session()->has('sukses'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3" data-reveal="up">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="text-sm font-medium">{{ session('sukses') }}</span>
        </div>
        @endif

        {{-- Statistik --}}
        <div class="grid grid-cols-3 gap-4 mb-10" data-stagger>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
                <div class="text-3xl font-black text-yellow-600">{{ $statistik['menunggu'] }}</div>
                <div class="text-xs text-gray-500 font-medium mt-1">Menunggu</div>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
                <div class="text-3xl font-black text-green-600">{{ $statistik['disetujui'] }}</div>
                <div class="text-xs text-gray-500 font-medium mt-1">Disetujui</div>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
                <div class="text-3xl font-black text-blue-600">{{ $statistik['selesai'] }}</div>
                <div class="text-xs text-gray-500 font-medium mt-1">Selesai</div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Kolom Kiri: Jadwal Saya --}}
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm" data-reveal="left">
                    <h2 class="font-bold text-gray-900 flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Jadwal Saya
                    </h2>
                    @forelse($jadwals as $j)
                    <div class="flex items-center justify-between py-2.5 border-b border-gray-100 last:border-0">
                        <span class="font-semibold text-gray-700 capitalize">{{ $j->hari }}</span>
                        <span class="text-sm text-gray-500">{{ substr($j->jam_mulai,0,5) }}-{{ substr($j->jam_selesai,0,5) }}</span>
                    </div>
                    @empty
                    <p class="text-sm text-gray-400 text-center py-4">Belum ada jadwal. Hubungi admin untuk menambahkan.</p>
                    @endforelse
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm" data-reveal="left" data-reveal-delay="100">
                    <h2 class="font-bold text-gray-900 flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Informasi Kontak
                    </h2>
                    @if($konselor->email)<p class="text-sm text-gray-500 mb-1">Email: {{ $konselor->email }}</p>@endif
                    @if($konselor->link_wa)<p class="text-sm text-gray-500 mb-1">WhatsApp: <a href="{{ $konselor->link_wa }}" target="_blank" rel="noopener" class="text-green-600 hover:underline font-medium">{{ $konselor->nomor_hp }}</a></p>@endif
                    @if($konselor->nip)<p class="text-sm text-gray-500">NIP: {{ $konselor->nip }}</p>@endif
                </div>
            </div>

            {{-- Kolom Kanan: Daftar Booking --}}
            <div class="lg:col-span-2" data-reveal="right">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="p-5 lg:p-6 border-b border-gray-100">
                        <h2 class="font-bold text-gray-900 mb-4">Daftar Booking Mahasiswa</h2>
                        <div class="flex gap-2 p-1 bg-gray-100 rounded-xl w-fit">
                            <button wire:click="$set('tab', 'menunggu')" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-300 {{ $tab == 'menunggu' ? 'bg-white text-yellow-700 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Menunggu</button>
                            <button wire:click="$set('tab', 'aktif')" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-300 {{ $tab == 'aktif' ? 'bg-white text-yellow-700 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Disetujui</button>
                            <button wire:click="$set('tab', 'selesai')" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-300 {{ $tab == 'selesai' ? 'bg-white text-yellow-700 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Selesai</button>
                        </div>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @forelse($bookings as $b)
                        <div class="p-5 lg:p-6">
                            <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="px-2.5 py-0.5 text-xs font-bold rounded-full
                                            {{ $b->status == 'menunggu' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                            {{ $b->status == 'disetujui' ? 'bg-green-100 text-green-700' : '' }}
                                            {{ $b->status == 'selesai' ? 'bg-blue-100 text-blue-700' : '' }}
                                            {{ $b->status == 'ditolak' ? 'bg-red-100 text-red-700' : '' }}
                                            {{ $b->status == 'dibatalkan' ? 'bg-gray-100 text-gray-600' : '' }}">
                                            {{ ucfirst($b->status) }}
                                        </span>
                                        <span class="text-xs text-gray-400 font-mono">{{ $b->kode_booking }}</span>
                                    </div>
                                    <h3 class="font-bold text-gray-900">{{ $b->nama_mahasiswa }} <span class="text-xs text-gray-400 font-normal">({{ $b->nim }})</span></h3>
                                    <p class="text-sm text-gray-500 mt-0.5">{{ $b->prodi }}</p>
                                    <div class="flex flex-wrap gap-x-4 gap-y-1 mt-2 text-sm text-gray-500">
                                        <span>{{ \Carbon\Carbon::parse($b->tanggal)->isoFormat('D MMMM Y') }} • {{ substr($b->jam_sesi,0,5) }} WIB</span>
                                    </div>
                                    @if($b->deskripsi_masalah)
                                    <p class="text-sm text-gray-600 mt-3 bg-gray-50 rounded-lg p-3 leading-relaxed">
                                        <span class="font-semibold text-gray-700">Deskripsi Masalah:</span><br>{{ $b->deskripsi_masalah }}
                                    </p>
                                    @endif
                                </div>

                                {{-- Aksi Konselor --}}
                                <div class="lg:w-64 shrink-0 space-y-3">
                                    @if(in_array($b->status, ['disetujui', 'menunggu']))
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Link Meeting</label>
                                        <input type="url" wire:model="linkMeeting.{{ $b->id }}" placeholder="https://zoom.us/..." class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Catatan Konselor</label>
                                        <textarea wire:model="catatan.{{ $b->id }}" rows="2" placeholder="Catatan hasil konseling..." class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"></textarea>
                                    </div>
                                    <div class="flex gap-2">
                                        @if($b->status == 'menunggu')
                                        <button wire:click="ubahStatus({{ $b->id }}, 'disetujui')" class="flex-1 px-3 py-2 bg-green-500 text-white text-xs font-bold rounded-lg hover:bg-green-600 transition">Setuju</button>
                                        <button wire:click="ubahStatus({{ $b->id }}, 'ditolak')" class="flex-1 px-3 py-2 bg-red-500 text-white text-xs font-bold rounded-lg hover:bg-red-600 transition">Tolak</button>
                                        @elseif($b->status == 'disetujui')
                                        <button wire:click="ubahStatus({{ $b->id }}, 'selesai')" class="flex-1 px-3 py-2 bg-blue-500 text-white text-xs font-bold rounded-lg hover:bg-blue-600 transition">Selesaikan</button>
                                        @endif
                                    </div>
                                    @elseif($b->status == 'selesai')
                                    <div class="p-3 bg-blue-50 border border-blue-100 rounded-lg">
                                        <p class="text-xs font-bold text-blue-700 mb-1">Catatan Konselor:</p>
                                        <p class="text-xs text-blue-600 leading-relaxed">{{ $b->catatan_konselor ?? 'Tidak ada catatan.' }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-16">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <p class="text-gray-500 font-medium">Tidak ada booking pada tab ini</p>
                        </div>
                        @endforelse
                    </div>

                    <div class="p-4 border-t border-gray-100">
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
