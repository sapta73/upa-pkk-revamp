<x-guest-layout>
    <div class="text-center mb-6">
        <img src="{{ asset('img/logo upa pkk.png') }}" alt="UPA PKK" class="h-16 mx-auto mb-3">
        <h1 class="text-xl font-bold text-[#303030]">Verifikasi Email</h1>
        <p class="mt-1 text-sm text-gray-500">Satu langkah lagi sebelum akun Anda aktif.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            Tautan verifikasi baru telah dikirim ke email Anda.
        </div>
    @endif

    <p class="text-sm text-gray-600 leading-relaxed">
        Kami telah mengirim tautan verifikasi ke alamat email yang Anda daftarkan. Buka tautan tersebut untuk mengaktifkan akun. Jika belum menerima, periksa folder spam atau kirim ulang email verifikasi.
    </p>

    <div class="mt-6 flex flex-col gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button class="w-full justify-center">
                Kirim Ulang Email Verifikasi
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-bold text-[#303030] transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#ffb600] focus:ring-offset-2">
                Keluar
            </button>
        </form>
    </div>

    <p class="mt-5 text-center text-xs text-gray-500">
        Anda tetap dapat membuka halaman profil untuk mengganti email.
    </p>
</x-guest-layout>
