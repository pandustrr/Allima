@extends('layouts.app')

@section('title', 'Form Pemesanan - ' . $product->name)

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <i class="fas fa-home mr-2"></i>
                            Beranda
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Pesan {{ $product->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Product Info -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="w-full md:w-1/3">
                        <img src="{{ $product->image ?? 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}"
                            class="w-full rounded-lg object-cover">
                    </div>
                    <div class="w-full md:w-2/3">
                        <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $product->name }}</h1>
                        <div class="flex items-center mb-4">
                            <span class="text-xl font-bold text-blue-600">Rp
                                {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span
                                class="ml-4 px-2 py-1 text-xs font-semibold rounded-full {{ $product->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}
                            </span>
                        </div>
                        <p class="text-gray-600 mb-4">{{ $product->description }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Form -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Form Pemesanan</h2>

                <form id="orderForm" action="#" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap*</label>
                            <input type="text" id="name" name="name" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp*</label>
                            <input type="tel" id="phone" name="phone" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="email" name="email"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Jumlah*</label>
                            <input type="number" id="quantity" name="quantity" min="1" max="{{ $product->stock }}"
                                value="1" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Pengiriman*</label>
                            <textarea id="address" name="address" rows="3" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                            <textarea id="notes" name="notes" rows="2"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Contoh: Warna, Ukuran, dll"></textarea>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <h3 class="font-medium text-gray-800 mb-3">Ringkasan Pesanan</h3>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium" id="subtotal">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Ongkos Kirim</span>
                            <span class="font-medium">-</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-gray-800 border-t pt-2">
                            <span>Total</span>
                            <span id="total">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col md:flex-row gap-3">
                        <a href="#" id="whatsappBtn"
                            class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-md flex items-center justify-center transition duration-300">
                            <i class="fab fa-whatsapp mr-2"></i> Pesan via WhatsApp
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Function to generate WhatsApp message
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

            return `Halo, saya ingin memesan produk berikut:

*Produk:* ${productName}
*Jumlah:* ${quantity}
*Harga Satuan:* Rp ${pricePerItem.toLocaleString('id-ID')}
*Total Harga:* Rp ${totalPrice.toLocaleString('id-ID')}

*Data Pemesan:*
Nama: ${name}
No. WhatsApp: ${phone}
Email: ${email}
Alamat: ${address}

Catatan: ${notes}

Mohon konfirmasi ketersediaan dan total pembayaran termasuk ongkos kirim. Terima kasih.`;
        }

        // Update WhatsApp link when form changes
        document.getElementById('orderForm').addEventListener('input', function() {
            const whatsappBtn = document.getElementById('whatsappBtn');
            const message = encodeURIComponent(generateWhatsAppMessage());
            whatsappBtn.href = `https://wa.me/62895352729214?text=${message}`;
        });

        // Update quantity and total price
        document.getElementById('quantity').addEventListener('input', function() {
            const quantity = parseInt(this.value);
            const price = {{ $product->price }};
            const subtotal = quantity * price;

            document.getElementById('subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            document.getElementById('total').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');

            // Also update the WhatsApp link
            const whatsappBtn = document.getElementById('whatsappBtn');
            const message = encodeURIComponent(generateWhatsAppMessage());
            whatsappBtn.href = `https://wa.me/62895352729214?text=${message}`;
        });

        // Initialize WhatsApp link on page load
        document.addEventListener('DOMContentLoaded', function() {
            const whatsappBtn = document.getElementById('whatsappBtn');
            const message = encodeURIComponent(generateWhatsAppMessage());
            whatsappBtn.href = `https://wa.me/62895352729214?text=${message}`;
        });
    </script>
@endsection
