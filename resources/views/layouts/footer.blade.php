<footer class="bg-[#303030] text-white mt-12" data-footer style="opacity:0;transform:translateY(30px);transition:opacity 700ms cubic-bezier(0.4,0,0.2,1), transform 700ms cubic-bezier(0.4,0,0.2,1);">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid md:grid-cols-3 gap-8">
            <div data-reveal="up" data-reveal-delay="100">
                <img src="{{ asset('img/logo upa pkk.png') }}" alt="UPA PKK" class="h-12 mb-4">
                <p class="text-sm text-gray-400">Unit Penunjang Akademik Pengembangan Karir dan Kewirausahaan Universitas Bangka Belitung</p>
            </div>
            <div data-reveal="up" data-reveal-delay="200">
                <h4 class="font-bold mb-4 text-[#ffb600]">Link Cepat</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="{{ url('/berita') }}" class="hover:text-[#ffb600] transition hover:translate-x-1 inline-block">Berita</a></li>
                    <li><a href="{{ url('/bimbingan-konseling') }}" class="hover:text-[#ffb600] transition hover:translate-x-1 inline-block">Bimbingan Konseling</a></li>
                    <li><a href="{{ url('/ppid') }}" class="hover:text-[#ffb600] transition hover:translate-x-1 inline-block">PPID</a></li>
                    <li><a href="{{ url('/karir') }}" class="hover:text-[#ffb600] transition hover:translate-x-1 inline-block">Karir</a></li>
                </ul>
            </div>
            <div data-reveal="up" data-reveal-delay="300">
                <h4 class="font-bold mb-4 text-[#ffb600]">Kontak</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li>UPA PKK Universitas Bangka Belitung</li>
                    <li>Telp: (0717) 422145</li>
                    <li>Email: upa-pkk@ubb.ac.id</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-4 text-center text-sm text-gray-500" data-reveal="up" data-reveal-delay="400">
            &copy; {{ date('Y') }} UPA PKK UBB. Hak Cipta Dilindungi.
        </div>
    </div>
</footer>
