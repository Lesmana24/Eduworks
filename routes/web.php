<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;       // Controller untuk Pengunjung (Public)
use App\Http\Controllers\AdminProductController;  // Controller untuk Admin (CRUD)
use App\Http\Controllers\CategoriesController as CategoryController;
use App\Http\Controllers\AdminDashboardController;

/*
|--------------------------------------------------------------------------
| ROUTE PUBLIK / PENGUNJUNG (Bisa diakses siapa saja)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cart', [HomeController::class, 'cart'])->name('cart');

// Halaman Produk untuk Pengunjung (Hanya View & Show)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

/*
|--------------------------------------------------------------------------
| ROUTE ADMIN (Harus Login)
|--------------------------------------------------------------------------
*/

Route::middleware('auth','admin')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- ADMIN: CATEGORIES ---
    // Nama route 'categories-admin' didefinisikan di sini agar sesuai dengan navigasi
    Route::get('/categories-admin', [CategoryController::class, 'index'])->name('categories-admin');
    Route::get('/categories-admin/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories-admin', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories-admin/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories-admin/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories-admin/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // --- ADMIN: PRODUCTS ---
    // Menggunakan AdminProductController
    Route::get('/products-admin', [AdminProductController::class, 'index'])->name('products-admin');
    Route::get('/products-admin/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products-admin', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products-admin/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products-admin/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products-admin/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
});

require __DIR__.'/auth.php';
