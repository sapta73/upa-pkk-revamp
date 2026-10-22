<section id="hapus-akun" class="bg-white border border-[#f3c7c9] rounded-2xl shadow-sm">
    <div class="p-6 sm:p-8">
        <h2 class="text-xl font-bold text-[#c0343d]">Hapus Akun</h2>
        <p class="mt-2 text-sm text-gray-600 max-w-2xl">Setelah akun dihapus, Anda tidak bisa login kembali. Riwayat booking tetap tersimpan tanpa tautan ke akun Anda.</p>
        <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'konfirmasi-hapus-akun')" class="mt-5">
            Hapus Akun
        </x-danger-button>
    </div>

    <x-modal name="konfirmasi-hapus-akun" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profil.destroy') }}" class="p-6 sm:p-8">
            @csrf
            @method('delete')

            <h3 class="text-lg font-bold text-[#252525]">Hapus akun Anda?</h3>
            <p class="mt-2 text-sm text-gray-600">Masukkan password untuk mengonfirmasi. Tindakan ini tidak bisa dibatalkan.</p>

            <div class="mt-5">
                <x-input-label for="password" value="Password" class="sr-only" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" placeholder="Password" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-danger-button>Hapus Akun</x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
