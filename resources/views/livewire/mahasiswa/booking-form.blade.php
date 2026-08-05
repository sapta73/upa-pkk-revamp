<div>
    <div class="max-w-4xl mx-auto px-4 py-10 lg:py-16">
        {{-- Header --}}
        <div class="text-center mb-10" data-reveal="up">
            <h1 class="text-3xl lg:text-4xl font-black text-gray-900 tracking-tight">Booking Konseling</h1>
            <p class="text-gray-500 mt-2">Isi data dan jadwalkan sesi konselingmu</p>
        </div>

        {{-- Stepper Progress --}}
        @if(!$bookingBerhasil)
        <div class="max-w-2xl mx-auto mb-10">
            <div class="flex items-center justify-between">
                @php $steps = ['Pilih Konselor', 'Lengkapi Data', 'Konfirmasi']; @endphp
                @foreach($steps as $i => $s)
                <div class="flex items-center">
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold transition-all duration-500
                            {{ $step > $i + 1 ? 'bg-yellow-500 text-white' : ($step == $i + 1 ? 'bg-yellow-500 text-white shadow-lg shadow-yellow-500/30' : 'bg-gray-100 text-gray-400') }}">
                            @if($step > $i + 1)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            @else
                                {{ $i + 1 }}
                            @endif
                        </div>
                        <span class="text-xs mt-1.5 {{ $step == $i + 1 ? 'text-yellow-600 font-semibold' : 'text-gray-400' }}">{{ $s }}</span>
                    </div>
                    @if($i < count($steps) - 1)
                    <div class="w-16 sm:w-24 h-0.5 mx-2 {{ $step > $i + 1 ? 'bg-yellow-500' : 'bg-gray-200' }}"></div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- SUCCESS STATE --}}
        @if($bookingBerhasil)
            <div class="max-w-lg mx-auto text-center" data-reveal="up">
                <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-green-500/30">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h2 class="text-2xl lg:text-3xl font-black text-gray-900 mb-2">Booking Berhasil! 🎉</h2>
                <p class="text-gray-500 mb-2">Sesi konselingmu telah terdaftar.</p>

                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 my-6 text-left">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm text-gray-500">Kode Booking</span>
                        <span class="text-lg font-black text-yellow-600 tracking-wider">{{ $kodeBooking }}</span>
                    </div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm text-gray-500">Status</span>
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">Menunggu Konfirmasi</span>
                    </div>
                    @if($konselor)
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm text-gray-500">Konselor</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $konselor->nama }}</span>
                    </div>
                    @endif
                    @if($tanggal)
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm text-gray-500">Tanggal</span>
                        <span class="text-sm font-semibold text-gray-900">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</span>
                    </div>
                    @endif
                    @if($jamSesiTerpilih)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Jam Sesi</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $jamSesiTerpilih }} WIB</span>
                    </div>
                    @endif
                </div>

                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ url('/mahasiswa/my-booking') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-[#ffb600] text-white font-bold rounded-xl shadow-lg shadow-[#ffb600]/30 hover:shadow-[#ffb600]/50 transition-all duration-300 hover:scale-[1.02]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Lihat Booking Saya
                    </a>
                    <a href="{{ url('/bimbingan-konseling') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-white border border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-all duration-300">
                        Kembali ke BK
                    </a>
                </div>
            </div>

        {{-- STEP 1: Pilih Konselor --}}
        @elseif($step == 1)
            <div class="max-w-3xl mx-auto">
                <h2 class="text-xl font-bold text-gray-900 mb-2">Pilih Konselor</h2>
                <p class="text-gray-500 mb-6">Klik konselor yang sesuai dengan kebutuhanmu.</p>
                <div class="grid md:grid-cols-2 gap-4" data-stagger>
                    @foreach($konselors as $k)
                    <button wire:click="pilihKonselor({{ $k->id }})" class="group text-left p-5 bg-white rounded-2xl border-2 border-gray-100 hover:border-yellow-400 hover:shadow-lg hover:shadow-yellow-500/5 transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl overflow-hidden bg-gradient-to-br from-yellow-100 to-amber-100 shrink-0 flex items-center justify-center">
                                @if($k->foto)
                                    <img src="{{ asset('storage/' . $k->foto) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <span class="text-xl font-black text-yellow-600">{{ substr($k->nama, 0, 1) }}</span>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $k->nama }}</h3>
                                <p class="text-sm text-yellow-600">{{ $k->spesialisasi }}</p>
                            </div>
                        </div>
                    </button>
                    @endforeach
                </div>
            </div>

        {{-- STEP 2 & 3: Form + Review --}}
        @elseif($step == 2 || $step == 3)
            <div class="max-w-2xl mx-auto">
                {{-- Step 2: Form --}}
                @if($step == 2)
                <div class="bg-white rounded-2xl p-6 lg:p-8 border border-gray-100 shadow-sm">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-2xl overflow-hidden bg-gradient-to-br from-yellow-100 to-amber-100 shrink-0 flex items-center justify-center">
                            @if($konselor && $konselor->foto)
                                <img src="{{ asset('storage/' . $konselor->foto) }}" alt="" class="w-full h-full object-cover">
                            @else
                                <span class="text-lg font-black text-yellow-600">{{ $konselor ? substr($konselor->nama, 0, 1) : '?' }}</span>
                            @endif
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Booking dengan {{ $konselor?->nama }}</h2>
                            <p class="text-sm text-yellow-600">{{ $konselor?->spesialisasi }}</p>
                        </div>
                    </div>

                    <form wire:submit="booking" class="space-y-5">

                        {{-- STEP A: Tanggal Sesi (WAJIB pilih duluan) --}}
                        <div>
                            <label for="tanggal" class="flex items-center gap-1.5 text-sm font-semibold text-gray-700 mb-1.5">
                                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Tanggal Sesi
                            </label>
                            <input id="tanggal" type="date" wire:model="tanggal" wire:change="pilihTanggal($event.target.value)" min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition">
                            @error('tanggal') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Feedback hari dari tanggal terpilih --}}
                        @if($tanggal)
                        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-xl flex items-start gap-3">
                            <svg class="w-5 h-5 text-yellow-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <div>
                                <p class="text-sm text-yellow-800">
                                    <span class="font-bold">Hari {{ $this->namaHariTanggal() }}</span>
                                    @if($jadwalTersedia->isNotEmpty())
                                        — pilih slot waktu yang tersedia di bawah.
                                    @else
                                        — <span class="font-semibold">tidak ada jadwal tersedia di hari ini.</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        @endif

                        {{-- STEP B: Pilih Jadwal (dependent — baru aktif setelah tanggal dipilih) --}}
                        <div>
                            <label for="selectedJadwal" class="flex items-center gap-1.5 text-sm font-semibold text-gray-700 mb-1.5">
                                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Pilih Jadwal
                            </label>
                            <select id="selectedJadwal" wire:model="selectedJadwal" wire:change="pilihJadwal($event.target.value)" {{ $tanggal ? '' : 'disabled' }}
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition disabled:opacity-60 disabled:cursor-not-allowed">
                                @if(!$tanggal)
                                    <option value="">Pilih tanggal terlebih dahulu</option>
                                @elseif($jadwalTersedia->isEmpty())
                                    <option value="">Tidak ada jadwal tersedia di hari {{ $this->namaHariTanggal() }}</option>
                                @else
                                    <option value="">— Pilih jadwal —</option>
                                    @foreach($jadwalTersedia as $j)
                                    <option value="{{ $j->id }}">{{ substr($j->jam_mulai,0,5) }} – {{ substr($j->jam_selesai,0,5) }} WIB (Sisa kuota: {{ $j->sisa_kuota }})</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('selectedJadwal') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- STEP C: Deskripsi Masalah --}}
                        <div>
                            <label for="deskripsiMasalah" class="flex items-center gap-1.5 text-sm font-semibold text-gray-700 mb-1.5">
                                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                                Deskripsi Masalah
                            </label>
                            <textarea id="deskripsiMasalah" wire:model="deskripsiMasalah" rows="4"
                                      class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                                      placeholder="Jelaskan secara singkat masalah atau topik yang ingin dikonsultasikan..."></textarea>
                            @error('deskripsiMasalah') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" {{ $selectedJadwal ? '' : 'disabled' }}
                                class="w-full py-3.5 bg-[#ffb600] text-white font-bold rounded-xl shadow-lg shadow-[#ffb600]/30 hover:shadow-[#ffb600]/50 transition-all duration-300 hover:scale-[1.01] active:scale-[0.99] disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100">
                            Booking Sekarang
                        </button>
                    </form>
                </div>
                @endif
            </div>
        @endif
    </div>
</div>
