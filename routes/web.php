<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Public Routes (bisa diakses tanpa login)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk/{product}', [ProductController::class, 'show'])->name('product.show');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected User Routes (harus login)
Route::middleware('auth')->group(function () {
    // Cart Routes
    Route::post('/produk/{product}/tambah-keranjang', [CartController::class, 'store'])->name('cart.add');

    Route::prefix('keranjang')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::put('/{item}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/{item}', [CartController::class, 'destroy'])->name('cart.remove');
    });

    Route::post('/keranjang/konfirmasi', [CartController::class, 'confirm'])->name('cart.confirm');
    Route::get('/terima-kasih', [CartController::class, 'thankYou'])->name('cart.thankyou');

});

// Admin Routes (tidak diubah)
Route::prefix('admin')->group(function () {
    // Auth routes
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

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

        Route::resource('users', UserController::class)->names([
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ])->except(['show']);
    });
});
