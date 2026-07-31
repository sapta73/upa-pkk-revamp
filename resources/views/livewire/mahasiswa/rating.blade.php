<div>
    <div class="max-w-2xl mx-auto px-4 py-10 lg:py-16">
        {{-- Header --}}
        <div class="text-center mb-10" data-reveal="up">
            <div class="w-20 h-20 bg-gradient-to-br from-[#ffb600] to-[#ffc009] rounded-3xl flex items-center justify-center text-white shadow-lg shadow-[#ffb600]/30 mx-auto mb-5">
                <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            </div>
            <h1 class="text-3xl lg:text-4xl font-black text-gray-900 tracking-tight">Beri Rating Konselor</h1>
            <p class="text-gray-500 mt-2">Bagaimana pengalaman sesi konselingmu dengan <span class="font-semibold text-gray-700">{{ $booking->konselor->nama }}</span>?</p>
        </div>

        @if(session()->has('sukses'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3" data-reveal="up">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="text-sm font-medium">{{ session('sukses') }}</span>
        </div>
        @endif

        <form wire:submit="simpan" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:p-8" data-reveal="up" data-reveal-delay="100">
            {{-- Detail Sesi --}}
            <div class="mb-8 p-4 bg-gray-50 rounded-xl text-sm text-gray-600 flex flex-wrap gap-x-6 gap-y-1">
                <span><span class="font-semibold text-gray-800">Kode:</span> <span class="font-mono">{{ $booking->kode_booking }}</span></span>
                <span><span class="font-semibold text-gray-800">Tanggal:</span> {{ \Carbon\Carbon::parse($booking->tanggal)->isoFormat('D MMMM Y') }}</span>
                <span><span class="font-semibold text-gray-800">Konselor:</span> {{ $booking->konselor->nama }}</span>
            </div>

            {{-- Pilihan Rating --}}
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-3">Seberapa puas kamu dengan sesi ini?</label>
                <div class="flex gap-2">
                    @for($i = 1; $i <= 5; $i++)
                    <button type="button"
                            wire:click="$set('rating', {{ $i }})"
                            class="group p-2 rounded-xl transition-all duration-200 hover:scale-110 focus:outline-none"
                            aria-label="Rating {{ $i }} dari 5">
                        <svg class="w-9 h-9 {{ $i <= $rating ? 'text-[#ffb600]' : 'text-gray-300' }} transition-colors duration-200" fill="{{ $i <= $rating ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    </button>
                    @endfor
                </div>
                <p class="text-sm mt-2 font-medium {{ $rating <= 2 ? 'text-red-500' : ($rating == 3 ? 'text-yellow-600' : 'text-green-600') }}">
                    @switch($rating)
                        @case(1) Sangat Kurang Baik @break
                        @case(2) Kurang Baik @break
                        @case(3) Cukup Baik @break
                        @case(4) Baik @break
                        @case(5) Sangat Baik @break
                    @endswitch
                </p>
                @error('rating') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Komentar --}}
            <div class="mb-8">
                <label for="komentar" class="block text-sm font-semibold text-gray-700 mb-2">Komentar (opsional)</label>
                <textarea id="komentar" wire:model="komentar" rows="4" placeholder="Ceritakan pengalamanmu sesi konseling ini..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#ffb600] focus:border-[#ffb600] focus:outline-none transition-all duration-300"></textarea>
                @error('komentar') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Aksi --}}
            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit" class="flex-1 px-6 py-3.5 bg-[#ffb600] text-white font-bold rounded-xl hover:bg-[#e6a400] transition-all duration-300 shadow-lg shadow-[#ffb600]/30 hover:scale-[1.01]">
                    Kirim Rating
                </button>
                <a href="{{ route('mahasiswa.my-booking') }}" class="px-6 py-3.5 bg-gray-100 text-gray-600 font-semibold rounded-xl hover:bg-gray-200 transition-all duration-300 text-center">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
