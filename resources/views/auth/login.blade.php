<x-guest-layout>
    <div class="text-center mb-6">
        <img src="{{ asset('img/logo upa pkk.png') }}" alt="UPA PKK" class="h-16 mx-auto mb-3">
        <h1 class="text-xl font-bold text-[#303030]">UPA PKK UBB</h1>
        <p class="text-sm text-gray-500">Masuk ke akun Anda</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <x-input-label for="email" :value="'Email'" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="'Kata Sandi'" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#ffb600] shadow-sm focus:ring-[#ffb600]" name="remember">
                <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a class="text-sm text-[#ffb600] hover:text-[#e6a400] underline" href="{{ route('password.request') }}">Lupa kata sandi?</a>
            @endif
            <button type="submit" class="bg-[#ffb600] text-white px-4 py-2 rounded-md hover:bg-[#e6a400] transition font-medium">
                Masuk
            </button>
        </div>

        <p class="text-center text-sm text-gray-500 mt-6">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-[#ffb600] hover:underline">Daftar</a>
        </p>
    </form>
</x-guest-layout>
