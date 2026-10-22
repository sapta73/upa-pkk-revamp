<section id="data-diri" class="bg-white border border-gray-200 rounded-2xl shadow-sm">
    <div class="p-6 sm:p-8 border-b border-gray-100">
        <h2 class="text-xl font-bold text-[#252525]">Data Diri</h2>
        <p class="mt-1 text-sm text-gray-500">Perbarui informasi akun Anda.</p>
    </div>

    <form method="post" action="{{ route('profil.update') }}" class="p-6 sm:p-8 space-y-6">
        @csrf
        @method('patch')

        <div class="grid sm:grid-cols-2 gap-5">
            <div>
                <x-input-label for="name" value="Nama Lengkap" />
                <x-text-input id="name" name="name" type="text" class="mt-1.5 block w-full" :value="old('name', $pengguna->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" name="email" type="email" class="mt-1.5 block w-full" :value="old('email', $pengguna->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                <p class="mt-2 text-xs text-gray-500">Perubahan email akan mereset status verifikasi.</p>
            </div>

            @if ($pengguna->role === 'mahasiswa')
                <div>
                    <x-input-label for="nim" value="NIM" />
                    <x-text-input id="nim" name="nim" type="text" class="mt-1.5 block w-full" :value="old('nim', $pengguna->nim)" required autocomplete="off" />
                    <x-input-error class="mt-2" :messages="$errors->get('nim')" />
                </div>

                <div>
                    <x-input-label for="prodi" value="Program Studi" />
                    <select id="prodi" name="prodi" class="mt-1.5 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#ffb600] focus:ring-[#ffb600]" required>
                        <option value="">Pilih Prodi</option>
                        @foreach (config('upa.prodi') as $prodi)
                            <option value="{{ $prodi }}" @selected(old('prodi', $pengguna->prodi) === $prodi)>{{ $prodi }}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('prodi')" />
                </div>

                <div>
                    <x-input-label for="nomor_hp" value="Nomor HP" />
                    <x-text-input id="nomor_hp" name="nomor_hp" type="text" class="mt-1.5 block w-full" :value="old('nomor_hp', $pengguna->nomor_hp)" required autocomplete="tel" />
                    <x-input-error class="mt-2" :messages="$errors->get('nomor_hp')" />
                </div>
            @elseif ($pengguna->role === 'konselor')
                <div>
                    <x-input-label for="nomor_hp" value="Nomor HP" />
                    <x-text-input id="nomor_hp" name="nomor_hp" type="text" class="mt-1.5 block w-full" :value="old('nomor_hp', $pengguna->nomor_hp)" required autocomplete="tel" />
                    <x-input-error class="mt-2" :messages="$errors->get('nomor_hp')" />
                </div>
            @elseif (in_array($pengguna->role, ['dosen', 'tendik']))
                <div>
                    <x-input-label for="nip" value="NIP" />
                    <x-text-input id="nip" name="nip" type="text" class="mt-1.5 block w-full" :value="old('nip', $pengguna->nip)" required autocomplete="off" />
                    <x-input-error class="mt-2" :messages="$errors->get('nip')" />
                </div>
                <div>
                    <x-input-label for="unit" value="Unit" />
                    <x-text-input id="unit" name="unit" type="text" class="mt-1.5 block w-full" :value="old('unit', $pengguna->unit)" required autocomplete="organization" />
                    <x-input-error class="mt-2" :messages="$errors->get('unit')" />
                </div>
            @endif
        </div>

        <div class="flex items-center gap-3">
            <x-primary-button>Simpan Perubahan</x-primary-button>
        </div>
    </form>
</section>
