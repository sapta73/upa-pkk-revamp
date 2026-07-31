<div>
    <div class="max-w-4xl mx-auto px-4 py-10 lg:py-16">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl lg:text-4xl font-black text-gray-900 tracking-tight">Booking Saya</h1>
                <p class="text-gray-500 mt-1">Kelola sesi konselingmu</p>
            </div>
            <a href="{{ url('/bimbingan-konseling') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#ffb600] text-white font-bold rounded-xl hover:bg-[#e6a400] transition-all duration-300 shadow-lg shadow-[#ffb600]/30">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Booking Baru
            </a>
        </div>

        {{-- Tab Navigation --}}
        <div class="flex gap-2 mb-8 p-1 bg-gray-100 rounded-xl w-fit">
            <button wire:click="$set('tab', 'aktif')" class="px-5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-300 {{ $tab == 'aktif' ? 'bg-white text-[#a16207] shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                <span class="flex items-center gap-2">
                    Aktif
                    @if($bookings->whereIn('status', ['menunggu','disetujui'])->count() > 0 && $tab == 'aktif')
                    <span class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></span>
                    @endif
                </span>
            </button>
            <button wire:click="$set('tab', 'riwayat')" class="px-5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-300 {{ $tab == 'riwayat' ? 'bg-white text-[#a16207] shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                Riwayat
            </button>
        </div>

        {{-- Booking Cards --}}
        @forelse($bookings as $b)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-4 hover:shadow-md transition-all duration-300 group"
             data-reveal="up">
            <div class="flex flex-col sm:flex-row">
                {{-- Status Accent Bar --}}
                <div class="w-full sm:w-2 shrink-0 h-1 sm:h-auto {{ $b->status == 'menunggu' ? 'bg-yellow-400' : ($b->status == 'disetujui' ? 'bg-green-400' : ($b->status == 'selesai' ? 'bg-blue-400' : 'bg-red-400')) }}"></div>

                <div class="flex-1 p-5 lg:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                        <div class="flex-1">
                            {{-- Status Badge + Kode --}}
                            <div class="flex items-center gap-3 mb-3">
                                <span class="px-3 py-1 text-xs font-bold rounded-full
                                    {{ $b->status == 'menunggu' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $b->status == 'disetujui' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $b->status == 'selesai' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $b->status == 'ditolak' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $b->status == 'dibatalkan' ? 'bg-gray-100 text-gray-600' : '' }}">
                                    @switch($b->status)
                                        @case('menunggu') Menunggu @break
                                        @case('disetujui') Disetujui @break
                                        @case('selesai') Selesai @break
                                        @case('ditolak') Ditolak @break
                                        @case('dibatalkan') Dibatalkan @break
                                        @default {{ $b->status }}
                                    @endswitch
                                </span>
                                <span class="text-xs text-gray-400 font-mono">{{ $b->kode_booking }}</span>
                            </div>

                            {{-- Konselor & Info --}}
                            <h3 class="font-bold text-gray-900 text-lg">{{ $b->konselor->nama }}</h3>
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-2 text-sm text-gray-500">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    {{ \Carbon\Carbon::parse($b->tanggal)->isoFormat('D MMMM Y') }}
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ substr($b->jam_sesi, 0, 5) }} WIB
                                </span>
                            </div>

                            {{-- Status Timeline --}}
                            <div class="flex items-center gap-1 mt-3">
                                @php
                                    $statusFlow = ['menunggu', 'disetujui', 'selesai'];
                                    $currentIdx = array_search($b->status, $statusFlow);
                                @endphp
                                @if($currentIdx !== false)
                                    @foreach($statusFlow as $i => $s)
                                    <div class="flex items-center">
                                        <div class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold
                                            {{ $i <= $currentIdx ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-400' }}">
                                            @if($i < $currentIdx)
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                            @elseif($i == $currentIdx && $s == 'menunggu')
                                                <div class="w-2 h-2 bg-white rounded-full"></div>
                                            @elseif($i == $currentIdx && $s == 'disetujui')
                                                <div class="w-2 h-2 bg-white rounded-full"></div>
                                            @elseif($i == $currentIdx && $s == 'selesai')
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                            @else
                                                <div class="w-1.5 h-1.5 bg-current rounded-full"></div>
                                            @endif
                                        </div>
                                        @if($i < count($statusFlow) - 1)
                                        <div class="w-6 h-0.5 {{ $i < $currentIdx ? 'bg-yellow-500' : 'bg-gray-200' }}"></div>
                                        @endif
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex sm:flex-col gap-2 sm:items-end shrink-0">
                            @if($b->status == 'disetujui' && $b->link_meeting)
                            <a href="{{ $b->link_meeting }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-500 text-white font-semibold text-sm rounded-xl hover:bg-green-600 transition-all duration-300 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                Gabung Meeting
                            </a>
                            @endif
                            @if(in_array($b->status, ['menunggu']))
                            <button wire:click="batalkan({{ $b->id }})" onclick="return confirm('Yakin ingin membatalkan booking ini?')" class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-50 text-red-600 font-medium text-sm rounded-xl hover:bg-red-100 transition-all duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Batalkan
                            </button>
                            @endif
                            @if($b->status == 'selesai' && !$b->rating)
                            <a href="{{ url('/mahasiswa/rating/' . $b->id) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-yellow-50 text-yellow-700 font-medium text-sm rounded-xl hover:bg-yellow-100 transition-all duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                Beri Rating
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        {{-- Empty State --}}
        <div class="text-center py-20" data-reveal="up">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-1">
                {{ $tab == 'aktif' ? 'Belum Ada Booking Aktif' : 'Belum Ada Riwayat Booking' }}
            </h3>
            <p class="text-gray-500 mb-6">
                {{ $tab == 'aktif' ? 'Kamu belum memiliki sesi konseling aktif. Yuk booking sekarang!' : 'Belum ada sesi konseling yang selesai.' }}
            </p>
            @if($tab == 'aktif')
            <a href="{{ url('/bimbingan-konseling') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#ffb600] text-white font-bold rounded-xl shadow-lg shadow-[#ffb600]/30 hover:shadow-[#ffb600]/50 transition-all duration-300 hover:scale-[1.02]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Booking Sekarang
            </a>
            @endif
        </div>
        @endforelse
    </div>
</div>
