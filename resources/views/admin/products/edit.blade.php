@extends('admin.layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-6">Edit Produk: {{ $product->name }}</h2>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                <input type="text" id="name" name="name" value="{{ $product->name }}" class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                <input type="number" id="price" name="price" value="{{ $product->price }}" class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                <input type="number" id="stock" name="stock" value="{{ $product->stock }}" class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">URL Gambar</label>
                <input type="url" id="image" name="image" value="{{ $product->image }}" class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="https://example.com/image.jpg">
            </div>

            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea id="description" name="description" rows="4" class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>{{ $product->description }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('admin.products.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded mr-3">
                Batal
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Update Produk
            </button>
        </div>
    </form>
</div>
@endsection
