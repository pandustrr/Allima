<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Produk
Route::get('/produk/{product}', [ProductController::class, 'show'])->name('product.show');
Route::post('/produk/{product}/tambah-keranjang', [CartController::class, 'store'])->name('cart.add');

// Keranjang
Route::prefix('keranjang')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::put('/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/{item}', [CartController::class, 'destroy'])->name('cart.remove');
});

Route::prefix('admin')->group(function () {
    // Auth routes
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout'); // Tambahkan ini

    // Dashboard dan route lainnya
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Product CRUD
        Route::resource('products', AdminController::class)->names([
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'show' => 'admin.products.show',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy',
        ]);
    });
});  
