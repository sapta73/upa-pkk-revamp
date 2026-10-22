<section id="keamanan" class="bg-white border border-gray-200 rounded-2xl shadow-sm">
    <div class="p-6 sm:p-8 border-b border-gray-100">
        <h2 class="text-xl font-bold text-[#252525]">Keamanan</h2>
        <p class="mt-1 text-sm text-gray-500">Gunakan password yang panjang dan unik.</p>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="p-6 sm:p-8 space-y-5">
        @csrf
        @method('put')

        <div>
            <x-input-label for="current_password" value="Password Saat Ini" />
            <x-text-input id="current_password" name="current_password" type="password" class="mt-1.5 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Password Baru" />
            <x-text-input id="password" name="password" type="password" class="mt-1.5 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi Password Baru" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1.5 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-3">
            <x-primary-button>Perbarui Password</x-primary-button>
            @if (session('status') === 'password-updated')
                <p class="text-sm font-medium text-green-700">Password berhasil diperbarui.</p>
            @endif
        </div>
    </form>
</section>
