<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online - Produk Terbaik</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo dan Menu Utama -->
                <div class="flex items-center">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex items-center">
                        <span class="text-xl font-bold text-blue-600">Toko<span class="text-gray-800">Online</span></span>
                    </a>

                    <!-- Menu Desktop -->
                    <div class="hidden md:ml-8 md:flex md:space-x-4">
                        <a href="{{ route('home') }}" class="px-3 py-2 rounded-md text-sm font-medium text-blue-700 bg-blue-50">Beranda</a>
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50">Kategori</a>
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50">Tentang Kami</a>
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50">Kontak</a>
                    </div>
                </div>

                <!-- Menu Kanan -->
                <div class="flex items-center space-x-4">
                    <!-- Keranjang -->
                    <a href="#" class="p-1 rounded-full text-gray-600 hover:text-blue-600 relative">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">0</span>
                    </a>

                    <!-- Status Auth -->
                    @auth('admin')
                        <!-- Admin Sudah Login -->
                        <div class="relative ml-3">
                            <div class="flex items-center space-x-2">
                                @if(request()->routeIs('admin.dashboard'))
                                    <span class="px-3 py-1 text-sm font-medium text-gray-700 flex items-center">
                                        <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                                    </span>
                                @else
                                    <a href="{{ route('admin.dashboard') }}" class="px-3 py-1 text-sm font-medium text-gray-700 hover:text-blue-600 flex items-center">

                                    </a>
                                @endif
                            </div>
                        </div>
                    @else
                        <!-- Belum Login -->
                        <a href="{{ route('admin.login') }}" class="ml-3 px-3 py-1 rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 flex items-center">
                            <i class="fas fa-user mr-1"></i> Masuk Admin
                        </a>
                    @endauth

                    <!-- Tombol Menu Mobile -->
                    <div class="md:hidden ml-2">
                        <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-blue-600 hover:bg-blue-50 focus:outline-none mobile-menu-button">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Mobile -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-blue-700 bg-blue-50">Beranda</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50">Kategori</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50">Tentang Kami</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50">Kontak</a>
            </div>
            <div class="pt-4 pb-3 border-t border-gray-200">
                @auth('admin')
                    <div class="flex items-center px-4">
                        <div class="text-sm font-medium text-gray-800">Admin Dashboard</div>
                    </div>
                    <div class="mt-3 px-2 space-y-1">
                        @if(request()->routeIs('admin.dashboard'))
                            <span class="block px-3 py-2 rounded-md text-base font-medium text-gray-600">Dashboard</span>
                        @else
                            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50"></a>
                        @endif
                    </div>
                @else
                    <a href="{{ route('admin.login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50">Login Admin</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-blue-600 text-white py-20">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold mb-2">Selamat Datang di TokoOnline</h2>
            <h3 class="text-2xl mb-8">Temukan produk terbaik dengan harga terbaik</h3>
            <a href="#products" class="bg-white text-blue-600 font-bold rounded-full py-4 px-8 shadow-lg uppercase tracking-wider hover:bg-gray-100 transition duration-300">Lihat Produk</a>
        </div>
    </div>

    <!-- Product Section -->
    <section id="products" class="container mx-auto px-6 py-12">
        <h2 class="text-3xl font-bold text-gray-800 mb-8">Daftar Produk</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                <div class="relative">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    @if($product->stock > 0)
                        <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">Tersedia</span>
                    @else
                        <span class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">Habis</span>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-xl mb-2 text-gray-800">{{ $product->name }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($product->description, 60) }}</p>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-gray-800">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <a href="{{ route('product.order', $product->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-300">
                            <i class="fas fa-cart-plus"></i> Beli
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="container mx-auto px-6">
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} TokoOnline. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.querySelector('.mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>
</html>
