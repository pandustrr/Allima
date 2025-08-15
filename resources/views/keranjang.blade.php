@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
    <div class="min-h-screen bg-gray-50 py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Keranjang Belanja</h1>
                <a href="{{ route('home') }}"
                    class="inline-flex items-center px-4 py-2 bg-[#56DFCF] text-gray-800 rounded-md hover:bg-[#0ABAB5] transition duration-150 ease-in-out">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Beranda
                </a>
            </div>

            @if ($cart->items->isEmpty())
                <div class="bg-white shadow-sm rounded-lg p-6 text-center">
                    <p class="text-gray-600 mb-4">Keranjang belanja Anda kosong</p>
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center px-4 py-2 bg-[#0ABAB5] text-white rounded-md hover:bg-[#56DFCF]">
                        Lanjutkan Belanja
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Daftar Produk -->
                    <div class="lg:col-span-2 space-y-4">
                        @foreach ($cart->items as $item)
                            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                                <div class="p-4 flex flex-col sm:flex-row">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $item->product->foto_url }}" alt="{{ $item->product->judul }}"
                                            class="w-24 h-32 object-cover rounded-md border border-gray-200">
                                    </div>
                                    <div class="mt-4 sm:mt-0 sm:ml-6 flex-1">
                                        <div class="flex justify-between">
                                            <div>
                                                <h3 class="text-lg font-medium text-gray-900">{{ $item->product->judul }}
                                                </h3>
                                                <p class="text-sm text-gray-600">Oleh: {{ $item->product->penulis }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-lg font-medium text-[#0ABAB5]">
                                                    Rp {{ number_format($item->product->harga, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="mt-4 flex items-center justify-between">
                                            <form action="{{ route('cart.update', $item) }}" method="POST"
                                                class="flex items-center">
                                                @csrf
                                                @method('PUT')
                                                <label for="quantity-{{ $item->id }}"
                                                    class="mr-2 text-sm text-gray-600">Jumlah:</label>
                                                <input type="number" id="quantity-{{ $item->id }}" name="quantity"
                                                    min="1" max="{{ $item->product->stok }}"
                                                    value="{{ $item->quantity }}"
                                                    class="w-20 px-2 py-1 border border-gray-300 rounded-md">
                                                <button type="submit"
                                                    class="ml-2 text-sm text-[#0ABAB5] hover:text-[#56DFCF]">
                                                    Update
                                                </button>
                                            </form>

                                            <form action="{{ route('cart.remove', $item) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>

                                        <div class="mt-2 flex justify-end">
                                            <p class="text-gray-900 font-medium">
                                                Subtotal: Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Ringkasan Pesanan -->
                    <div class="lg:col-span-1">
                        <div class="bg-white shadow-sm rounded-lg sticky top-6 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h3>

                            <div class="space-y-3">
                                @foreach ($cart->items as $item)
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">{{ $item->product->judul }}
                                            (x{{ $item->quantity }})
                                        </span>
                                        <span class="text-sm font-medium text-gray-900">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endforeach

                                <hr class="my-3 border-gray-200">

                                <div class="flex justify-between">
                                    <span class="text-base font-semibold text-gray-900">Total</span>
                                    <span class="text-lg font-bold text-[#0ABAB5]">
                                        Rp {{ number_format($cart->total, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Form Pemesanan -->
                            <form id="orderForm" class="mt-6 space-y-4">
                                <div>
                                    <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="customer_name" name="customer_name" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#0ABAB5] focus:border-[#0ABAB5]">
                                </div>

                                <div>
                                    <label for="pgtpq" class="block text-sm font-medium text-gray-700 mb-1">
                                        PGTPQ <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="pgtpq" name="pgtpq" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#0ABAB5] focus:border-[#0ABAB5]">
                                </div>

                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                                        Alamat Pengiriman <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="address" name="address" rows="3" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#0ABAB5] focus:border-[#0ABAB5]"
                                        placeholder="Masukkan alamat lengkap"></textarea>
                                </div>

                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                                        Catatan (Opsional)
                                    </label>
                                    <textarea id="notes" name="notes" rows="2"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#0ABAB5] focus:border-[#0ABAB5]"
                                        placeholder="Catatan khusus untuk penjual"></textarea>
                                </div>

                                <div class="flex space-x-3">
                                    <a href="{{ route('home') }}"
                                        class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition duration-150 ease-in-out">
                                        <i class="fas fa-arrow-left mr-2"></i>
                                        Kembali
                                    </a>
                                    <button type="button" id="whatsappBtn"
                                        class="flex-1 bg-[#25D366] hover:bg-[#128C7E] text-white font-medium py-2 px-4 rounded-md shadow-sm flex items-center justify-center transition duration-150 ease-in-out">
                                        <i class="fab fa-whatsapp mr-2 text-lg"></i>
                                        Pesan via WhatsApp
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const whatsappBtn = document.getElementById('whatsappBtn');

            whatsappBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // Ambil data form
                const name = document.getElementById('customer_name').value || '[Belum diisi]';
                const pgtpq = document.getElementById('pgtpq').value || '[Belum diisi]';
                const address = document.getElementById('address').value || '[Belum diisi]';
                const notes = document.getElementById('notes').value || '-';

                // Buat pesan
                let message = `*PEMESANAN BUKU*\n\n`;

                // Data Pemesan
                message += `*DATA PEMESAN*\n`;
                message += `Nama Lengkap : ${name}\n`;
                message += `PGTPQ        : ${pgtpq}\n`;
                message += `Alamat       : ${address}\n`;
                message += `Catatan      : ${notes}\n\n`;

                // Detail Pesanan
                message += `*DETAIL PESANAN*\n`;
                @foreach ($cart->items as $item)
                    message += `--------------------------------\n`;
                    message += `*Judul Buku*  : {!! $item->product->judul !!}\n`;
                    message += `Harga Satuan  : Rp {!! number_format($item->product->harga, 0, ',', '.') !!}\n`;
                    message += `Jumlah        : {!! $item->quantity !!} buku\n`;
                    message += `Subtotal      : Rp {!! number_format($item->subtotal, 0, ',', '.') !!}\n`;
                @endforeach

                // Total
                message += `\n*TOTAL PEMBAYARAN*: Rp {!! number_format($cart->total, 0, ',', '.') !!}\n\n`;
                message +=
                    `Mohon konfirmasi ketersediaan buku dan informasi total pembayaran termasuk ongkos kirim.\n`;
                message += `Terima kasih 🙏`;

                // Kirim ke WhatsApp
                const encodedMessage = encodeURIComponent(message);
                window.open(`https://wa.me/62895352729214?text=${encodedMessage}`, '_blank');
            });
        });
    </script>
@endsection
