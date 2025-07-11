@extends('layouts.app')

@section('title', 'Form Pemesanan - ' . $product->name)

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Form Pemesanan</h1>
                    <p class="text-sm text-gray-600 mt-1">Lengkapi formulir di bawah untuk melakukan pemesanan</p>
                </div>
                <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Product Information -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Informasi Produk</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Product Image -->
                            <div class="aspect-w-1 aspect-h-1">
                                <img src="{{ $product->image ?? 'https://via.placeholder.com/400' }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-64 object-cover rounded-lg shadow-sm border border-gray-200">
                            </div>

                            <!-- Product Details -->
                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">{{ $product->name }}</h3>
                                    <p class="text-2xl font-bold text-blue-600 mt-2">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                </div>

                                <div class="flex items-center">
                                    <span class="text-sm text-gray-500 mr-2">Status:</span>
                                    <span class="px-3 py-1 text-xs font-medium rounded-full {{ $product->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $product->stock > 0 ? 'Tersedia (' . $product->stock . ' unit)' : 'Habis' }}
                                    </span>
                                </div>

                                @if($product->description)
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Deskripsi</h4>
                                    <p class="text-sm text-gray-600 leading-relaxed">{{ $product->description }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Form -->
                <div class="bg-white shadow-sm rounded-lg mt-6">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Formulir Pemesanan</h2>

                        <form id="orderForm" action="#" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Nama Lengkap -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="name" name="name" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                                        placeholder="Masukkan nama lengkap Anda">
                                </div>

                                <!-- Nomor WhatsApp -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nomor WhatsApp <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" id="phone" name="phone" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                                        placeholder="Contoh: 08123456789">
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        Email
                                    </label>
                                    <input type="email" id="email" name="email"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                                        placeholder="email@example.com">
                                </div>

                                <!-- Jumlah -->
                                <div>
                                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                        Jumlah <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" id="quantity" name="quantity" min="1" max="{{ $product->stock }}"
                                            value="1" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <span class="text-gray-500 text-sm">unit</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Alamat Pengiriman -->
                            <div class="mt-6">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                    Alamat Pengiriman <span class="text-red-500">*</span>
                                </label>
                                <textarea id="address" name="address" rows="3" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                                    placeholder="Masukkan alamat lengkap untuk pengiriman"></textarea>
                            </div>

                            <!-- Catatan -->
                            <div class="mt-6">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Catatan (Opsional)
                                </label>
                                <textarea id="notes" name="notes" rows="2"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                                    placeholder="Contoh: Warna, ukuran, atau catatan khusus lainnya"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow-sm rounded-lg sticky top-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h3>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Produk</span>
                                <span class="text-sm font-medium text-gray-900">{{ $product->name }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Harga Satuan</span>
                                <span class="text-sm font-medium text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Jumlah</span>
                                <span class="text-sm font-medium text-gray-900" id="quantity-display">1 unit</span>
                            </div>
                            <hr class="my-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Subtotal</span>
                                <span class="text-sm font-medium text-gray-900" id="subtotal">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Ongkos Kirim</span>
                                <span class="text-sm text-gray-500">Akan dihitung</span>
                            </div>
                            <hr class="my-3">
                            <div class="flex justify-between items-center">
                                <span class="text-base font-semibold text-gray-900">Total</span>
                                <span class="text-lg font-bold text-blue-600" id="total">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="mt-6 space-y-3">
                            <a href="#" id="whatsappBtn"
                                class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg shadow-sm flex items-center justify-center transition duration-150 ease-in-out">
                                <i class="fab fa-whatsapp mr-2 text-lg"></i>
                                Pesan via WhatsApp
                            </a>
                            <p class="text-xs text-gray-500 text-center">
                                Dengan menekan tombol di atas, Anda akan diarahkan ke WhatsApp untuk menyelesaikan pemesanan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    
    function generateWhatsAppMessage() {
        const productName = "{{ $product->name }}";
        const quantity = document.getElementById('quantity').value;
        const pricePerItem = {{ $product->price }};
        const totalPrice = quantity * pricePerItem;
        const name = document.getElementById('name').value || '[Belum diisi]';
        const phone = document.getElementById('phone').value || '[Belum diisi]';
        const email = document.getElementById('email').value || '[Belum diisi]';
        const address = document.getElementById('address').value || '[Belum diisi]';
        const notes = document.getElementById('notes').value || '-';

        return `*PEMESANAN PRODUK*

*Produk:* ${productName}
*Jumlah:* ${quantity} unit
*Harga Satuan:* Rp ${pricePerItem.toLocaleString('id-ID')}
*Total Harga:* Rp ${totalPrice.toLocaleString('id-ID')}

*Data Pemesan:*
Nama: ${name}
No. WhatsApp: ${phone}
Email: ${email}
Alamat: ${address}

*Catatan:* ${notes}

Mohon konfirmasi ketersediaan dan total pembayaran termasuk ongkos kirim. Terima kasih! 🙏`;
    }

    // Update quantity display and calculations
    function updateQuantityDisplay() {
        const quantity = parseInt(document.getElementById('quantity').value) || 1;
        const price = {{ $product->price }};
        const subtotal = quantity * price;

        document.getElementById('quantity-display').textContent = quantity + ' unit';
        document.getElementById('subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        document.getElementById('total').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    }

    // Update WhatsApp link when form changes
    function updateWhatsAppLink() {
        const whatsappBtn = document.getElementById('whatsappBtn');
        const message = encodeURIComponent(generateWhatsAppMessage());
        whatsappBtn.href = `https://wa.me/62895352729214?text=${message}`;
    }

    // Event listeners
    document.getElementById('orderForm').addEventListener('input', function() {
        updateWhatsAppLink();
    });

    document.getElementById('quantity').addEventListener('input', function() {
        updateQuantityDisplay();
        updateWhatsAppLink();
    });

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateQuantityDisplay();
        updateWhatsAppLink();
    });
</script>
@endsectio
