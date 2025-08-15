<!-- footer.blade.php -->
<footer class="bg-[#0ABAB5] text-white mt-12">
    <div class="container mx-auto px-6 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Tentang Kami -->
            <div class="md:col-span-2">
                <h3 class="text-lg font-bold mb-4">TokoBuku Online</h3>
                <p class="text-[#ADEED9]">Menyediakan buku berkualitas dengan harga terbaik. Temukan koleksi buku terbaru dari berbagai genre.</p>
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="text-white hover:text-[#ADEED9]">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-white hover:text-[#ADEED9]">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-white hover:text-[#ADEED9]">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
            </div>

            <!-- Link Cepat -->
            <div>
                <h3 class="text-lg font-bold mb-4">Link Cepat</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-[#ADEED9] hover:text-white">Beranda</a></li>
                    <li><a href="#" class="text-[#ADEED9] hover:text-white">Produk</a></li>
                    <li><a href="#" class="text-[#ADEED9] hover:text-white">Tentang Kami</a></li>
                    <li><a href="#" class="text-[#ADEED9] hover:text-white">Kontak</a></li>
                </ul>
            </div>

            <!-- Kontak -->
            <div>
                <h3 class="text-lg font-bold mb-4">Hubungi Kami</h3>
                <ul class="space-y-2 text-[#ADEED9]">
                    <li class="flex items-center">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span>Jl. Buku No. 123, Jakarta</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone-alt mr-2"></i>
                        <span>(021) 1234-5678</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope mr-2"></i>
                        <span>info@tokobuku.com</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-[#56DFCF] mt-8 pt-6 text-center text-[#ADEED9] text-sm">
            <p>&copy; {{ date('Y') }} TokoBuku Online. All rights reserved.</p>
        </div>
    </div>
</footer>
