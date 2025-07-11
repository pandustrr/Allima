@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <p class="text-gray-600">Ini adalah halaman dashboard admin. Anda dapat mengelola produk dari sini.</p>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-blue-50 p-6 rounded-lg">
            <h3 class="text-lg font-medium text-blue-800">Total Produk</h3>
            <p class="text-3xl font-bold mt-2 text-blue-600">{{ App\Models\Product::count() }}</p>
            <a href="{{ route('admin.products.index') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-800">
                Lihat Produk <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        <div class="bg-green-50 p-6 rounded-lg">
            <h3 class="text-lg font-medium text-green-800">Produk Tersedia</h3>
            <p class="text-3xl font-bold mt-2 text-green-600">{{ App\Models\Product::where('stock', '>', 0)->count() }}</p>
        </div>

        <div class="bg-yellow-50 p-6 rounded-lg">
            <h3 class="text-lg font-medium text-yellow-800">Produk Habis</h3>
            <p class="text-3xl font-bold mt-2 text-yellow-600">{{ App\Models\Product::where('stock', 0)->count() }}</p>
        </div>
    </div>
</div>
@endsection
