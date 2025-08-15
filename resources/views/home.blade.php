@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-[#0ABAB5] text-white py-12 md:py-20">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-2">Selamat Datang di TokoBuku Online</h2>
            <h3 class="text-xl md:text-2xl mb-8">Temukan buku berkualitas dengan harga terbaik</h3>
            <a href="#produk" class="inline-block bg-white text-[#0ABAB5] font-bold rounded-full py-3 px-6 md:py-4 md:px-8 shadow-lg uppercase tracking-wider hover:bg-gray-100 transition duration-300">
                Lihat Koleksi Buku
            </a>
        </div>
    </div>

    <!-- Product Section -->
    <section id="produk" class="container mx-auto px-4 sm:px-6 py-8 md:py-12">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 md:mb-8 text-center">Koleksi Buku</h2>

        @if($products->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-600 text-lg">Belum ada buku yang tersedia saat ini.</p>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 flex flex-col h-full">
                    <a href="{{ route('product.show', $product->id) }}" class="flex-grow">
                        <div class="relative h-40 sm:h-48 md:h-56 overflow-hidden">
                            <img src="{{ $product->foto_url }}" alt="{{ $product->judul }}"
                                class="w-full h-full object-cover hover:scale-105 transition duration-300">
                            @if($product->stok > 0)
                                <span class="absolute top-2 right-2 bg-[#56DFCF] text-white text-xs px-2 py-1 rounded-full">
                                    Stok: {{ $product->stok }}
                                </span>
                            @else
                                <span class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                    Stok Habis
                                </span>
                            @endif
                        </div>

                        <div class="p-3 md:p-4">
                            <h3 class="font-bold text-sm md:text-base lg:text-lg mb-1 md:mb-2 text-gray-800 line-clamp-2">{{ $product->judul }}</h3>
                            <p class="text-gray-600 text-xs md:text-sm mb-2">Oleh: {{ $product->penulis }}</p>
                            <span class="font-bold text-[#0ABAB5] text-sm md:text-base">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </span>
                        </div>
                    </a>

                    <div class="p-3 md:p-4 pt-0">
                        @if($product->stok > 0)
                            @auth
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                                    @csrf
                                    <button type="submit" class="w-full bg-[#0ABAB5] hover:bg-[#56DFCF] text-white text-center text-xs md:text-sm font-medium py-2 px-2 md:py-2 md:px-4 rounded transition duration-300 flex items-center justify-center">
                                        <i class="fas fa-cart-plus mr-2"></i>
                                        Tambah ke Keranjang
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="w-full bg-[#0ABAB5] hover:bg-[#56DFCF] text-white text-center text-xs md:text-sm font-medium py-2 px-2 md:py-2 md:px-4 rounded transition duration-300 flex items-center justify-center">
                                    <i class="fas fa-sign-in-alt mr-2"></i>
                                    Login untuk Membeli
                                </a>
                            @endauth
                        @else
                            <button disabled class="w-full bg-gray-400 text-white text-center text-xs md:text-sm font-medium py-2 px-2 md:py-2 md:px-4 rounded cursor-not-allowed">
                                Stok Habis
                            </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </section>

    <div id="notification" class="fixed bottom-4 right-4 hidden">
        <div class="bg-[#0ABAB5] text-white px-4 py-3 rounded-md shadow-lg flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span id="notification-message"></span>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fungsi showNotification
    function showNotification(message, isError = false) {
        const notification = document.getElementById('notification');
        const messageEl = document.getElementById('notification-message');

        // Set pesan
        messageEl.textContent = message;

        // Set warna berdasarkan jenis notifikasi
        notification.firstElementChild.className = isError
            ? 'bg-red-500 text-white px-4 py-3 rounded-md shadow-lg flex items-center'
            : 'bg-[#0ABAB5] text-white px-4 py-3 rounded-md shadow-lg flex items-center';

        // Set ikon
        notification.firstElementChild.innerHTML = `
            <i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'} mr-2"></i>
            <span id="notification-message">${message}</span>
        `;

        // Tampilkan notifikasi
        notification.classList.remove('hidden');

        // Sembunyikan setelah 3 detik
        setTimeout(() => {
            notification.classList.add('hidden');
        }, 3000);
    }

    // Tangani form tambah ke keranjang
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const button = form.querySelector('button');
            const originalText = button.innerHTML;
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menambahkan...';

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        _token: '{{ csrf_token() }}',
                        quantity: 1
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Update jumlah keranjang di navbar
                    const cartCountElements = document.querySelectorAll('.cart-count');
                    cartCountElements.forEach(el => {
                        el.textContent = data.cartCount;
                        el.classList.remove('hidden');
                    });

                    // Tampilkan notifikasi
                    showNotification(data.message);
                } else {
                    showNotification(data.message, true);
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan', true);
            } finally {
                button.disabled = false;
                button.innerHTML = originalText;
            }
        });
    });
});
</script>
@endsection
