<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

Route::middleware(['guest'])->group(function () {
    // Register User Biasa
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    // Login (User & Admin)
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::prefix('user')->group(function () {
        Route::get('/katalog', [UserController::class, 'index'])->name('user.items'); // Lihat semua barang
        Route::post('/faktur/add/{id}', [UserController::class, 'addToCart'])->name('cart.add'); // Masukkan barang ke faktur
        Route::get('/faktur', [UserController::class, 'showCart'])->name('cart.show'); // Page khusus cetak faktur
        
        // Logika Update & Delete item di Faktur via AJAX/Fetch
        Route::patch('/faktur/update', [UserController::class, 'updateCart'])->name('cart.update');
        Route::delete('/faktur/remove', [UserController::class, 'removeFromCart'])->name('cart.remove');
        
        // Simpan Faktur & Cetak
        Route::post('/faktur/checkout', [UserController::class, 'checkout'])->name('cart.checkout'); // Simpan data faktur
        Route::get('/invoice/print/{id}', [UserController::class, 'printInvoice'])->name('user.invoice.print'); // Cetak struk barang
    });
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard'); // View barang admin
        Route::post('/category', [AdminController::class, 'storeCategory'])->name('admin.category.store'); // Tambah Kategori
        Route::post('/barang', [AdminController::class, 'storeItem'])->name('admin.item.store'); // Create Barang
        Route::put('/barang/{id}', [AdminController::class, 'updateItem'])->name('admin.item.update'); // Update Barang
        Route::delete('/barang/{id}', [AdminController::class, 'destroyItem'])->name('admin.item.destroy'); // Delete Barang
    });
});