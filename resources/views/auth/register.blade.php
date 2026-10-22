<x-guest-layout>
    <div class="text-center mb-6">
        <img src="{{ asset('img/logo upa pkk.png') }}" alt="UPA PKK" class="h-16 mx-auto mb-3">
        <h1 class="text-xl font-bold text-[#303030]">Daftar Akun</h1>
        <p class="text-sm text-gray-500">Mahasiswa UPA PKK UBB</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="grid md:grid-cols-2 gap-3">
            <div>
                <x-input-label for="name" :value="'Nama Lengkap'" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="nim" :value="'NIM'" />
                <x-text-input id="nim" class="block mt-1 w-full" type="text" name="nim" required />
                <x-input-error :messages="$errors->get('nim')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="email" :value="'Email'" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="prodi" :value="'Program Studi'" />
                <select id="prodi" name="prodi" class="block mt-1 w-full border-gray-300 rounded-xl shadow-sm focus:border-[#ffb600] focus:ring-[#ffb600]" required>
                    <option value="">Pilih Prodi</option>
                    @foreach (config('upa.prodi') as $prodi)
                        <option value="{{ $prodi }}" @selected(old('prodi') === $prodi)>{{ $prodi }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('prodi')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="nomor_hp" :value="'No. HP'" />
                <x-text-input id="nomor_hp" class="block mt-1 w-full" type="text" name="nomor_hp" required />
                <x-input-error :messages="$errors->get('nomor_hp')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="password" :value="'Kata Sandi'" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="password_confirmation" :value="'Konfirmasi Kata Sandi'" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full bg-[#ffb600] text-white px-4 py-2 rounded-md hover:bg-[#e6a400] transition font-medium">
                Daftar
            </button>
        </div>

        <p class="text-center text-sm text-gray-500 mt-4">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-[#ffb600] hover:underline">Masuk</a>
        </p>
    </form>
</x-guest-layout>
