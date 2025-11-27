<?php
// routes/web.php - SECCIÓN DE AUTENTICACIÓN

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\AccountController;

use App\Http\Controllers\ProductController;

// ==================== AUTENTICACIÓN ====================

// Login
Route::get('/login', [AccountController::class, 'login'])
    ->name('login');
Route::post('/authenticate',[AccountController::class, 'authenticate'])->name('auth.authenticate');


Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])
    ->name('auth.google')
    ->middleware('guest');

Route::get('/google-auth/callback', [GoogleController::class, 'handleGoogleCallback'])
    ->name('auth.google.callback')
    ->middleware('guest');


Route::post('/logout', [AccountController::class, 'logout'])
    ->name('logout');

// ==================== PRODUCTOS (Público) ====================

//Principal catálogo de productos
Route::get('/', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/productos/{id}', [ProductController::class, 'show'])
    ->name('products.show');



// ==================== Page (Público) ====================
use App\Http\Controllers\PageController;

//Principal catálogo de productos
Route::get('/about', [PageController::class, 'about'])
    ->name('page.about');



// ==================== CARRITO (Authenticated) ====================

use App\Http\Controllers\CartController;

// Route::middleware('auth')->group(function () {
//     Route::get('/carrito', [CartController::class, 'index'])
//         ->name('cart.index');

//     Route::post('/carrito/agregar/{id}', [CartController::class, 'add'])
//         ->name('cart.add');

//     Route::post('/carrito/actualizar/{id}', [CartController::class, 'update'])
//         ->name('cart.update');

//     Route::delete('/carrito/quitar/{id}', [CartController::class, 'remove'])
//         ->name('cart.remove');

//     Route::post('/carrito/vaciar', [CartController::class, 'clear'])
//         ->name('cart.clear');
// });

// ==================== CHECKOUT (Authenticated) ====================

use App\Http\Controllers\CheckoutController;

// Route::middleware('auth')->group(function () {
//     Route::get('/checkout', [CheckoutController::class, 'index'])
//         ->name('checkout.index');

//     Route::post('/checkout/procesar', [CheckoutController::class, 'process'])
//         ->name('checkout.process');

//     Route::get('/checkout/exitoso', [CheckoutController::class, 'success'])
//         ->name('checkout.success');
// });

// ==================== ÓRDENES DEL CLIENTE (Authenticated) ====================

use App\Http\Controllers\OrderController;

// Route::middleware('auth')->group(function () {
//     Route::get('/mis-compras', [OrderController::class, 'history'])
//         ->name('orders.history');

//     Route::get('/mis-compras/{id}', [OrderController::class, 'show'])
//         ->name('orders.show');
// });

// ==================== PANEL DE VENDEDOR (Vendor Only) ====================

use App\Http\Controllers\VendorController;

Route::middleware(['auth', 'vendor'])->prefix('vendor')->group(function () {
    // Dashboard
    Route::get('/dashboard', [VendorController::class, 'dashboard'])
        ->name('vendor.dashboard');

    // Gestionar Productos
    // Route::get('/productos', [ProductController::class, 'vendorIndex'])
    //     ->name('vendor.products.index');

    Route::get('/productos/crear', [ProductController::class, 'create'])
        ->name('vendor.products.create');

    Route::post('/productos', [ProductController::class, 'store'])
        ->name('vendor.products.store');

    Route::get('/productos/{id}/editar', [ProductController::class, 'edit'])
        ->name('vendor.products.edit');

    Route::put('/productos/{id}', [ProductController::class, 'update'])
        ->name('vendor.products.update');

    Route::delete('/productos/{id}', [ProductController::class, 'destroy'])
        ->name('vendor.products.destroy');

    // Gestionar Órdenes Recibidas
//     Route::get('/ordenes', [VendorController::class, 'orders'])
//         ->name('vendor.orders.index');

//     Route::post('/ordenes/{id}/estado', [VendorController::class, 'updateOrderStatus'])
//         ->name('vendor.orders.update-status');
});



// ==================== PERFIL DE USUARIO (Authenticated) ====================
use App\Http\Controllers\ProfileController;

Route::middleware('auth')->group(function () {
    // Ver perfil
    Route::get('/perfil', [ProfileController::class, 'show'])
        ->name('profile.show');

    // Actualizar información personal
    Route::put('/perfil/actualizar', [ProfileController::class, 'update'])
        ->name('profile.update');

    // Actualizar dirección
    Route::put('/perfil/direccion', [ProfileController::class, 'updateAddress'])
        ->name('profile.update-address');

    // Ver orden específica del perfil
    Route::get('/perfil/orden/{orderId}', [ProfileController::class, 'viewOrder'])
        ->name('profile.view-order');
});
