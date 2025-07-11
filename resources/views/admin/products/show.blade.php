@extends('admin.layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">Detail Produk: {{ $product->name }}</h2>
        <div class="flex space-x-2">
            <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                <i class="fas fa-edit mr-1"></i> Edit
            </a>
            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                    <i class="fas fa-trash mr-1"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <img src="{{ $product->image ?? 'https://via.placeholder.com/400' }}" alt="{{ $product->name }}" class="w-full rounded-lg shadow-md">
        </div>

        <div>
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-900">Informasi Produk</h3>
                <div class="mt-2 border-t border-gray-200 pt-4">
                    <dl class="divide-y divide-gray-200">
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Nama Produk</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">{{ $product->name }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Harga</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">Rp {{ number_format($product->price, 0, ',', '.') }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Stok</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->stock }}
                                </span>
                            </dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Tanggal Dibuat</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">{{ $product->created_at->format('d M Y H:i') }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Terakhir Diupdate</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">{{ $product->updated_at->format('d M Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900">Deskripsi Produk</h3>
                <div class="mt-2 border-t border-gray-200 pt-4">
                    <p class="text-sm text-gray-700">{{ $product->description }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar Produk
        </a>
    </div>
</div>
@endsection
