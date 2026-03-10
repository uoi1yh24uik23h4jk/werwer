<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicGameController;  // Добавьте этот импорт
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Auth;

// Публичные маршруты
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ПУБЛИЧНЫЙ КАТАЛОГ - используем PublicGameController
Route::get('/games', [PublicGameController::class, 'index'])->name('games.index');
Route::get('/games/{game}', [PublicGameController::class, 'show'])->name('games.show');

// Маршруты аутентификации
Auth::routes();

// Маршруты для авторизованных пользователей
Route::middleware('auth')->group(function() {
    
    // Корзина
    Route::get('/cart', [OrderController::class, 'cart'])->name('orders.cart');
    Route::post('/cart/add/{game}', [OrderController::class, 'addToCart'])->name('orders.add');
    Route::delete('/cart/remove/{id}', [OrderController::class, 'remove'])->name('orders.remove');
    
    // Оплата и заказы
    Route::get('/payment', [OrderController::class, 'payment'])->name('orders.payment');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');
    
    // Отзывы
    Route::post('/games/{game}/review', [ReviewController::class, 'store'])->name('reviews.store');
    
});

// ===== АДМИН-ПАНЕЛЬ (ВСЕ ЧТО СВЯЗАНО С АДМИНКОЙ) =====
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function() {
    
    // Dashboard
    Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])
        ->name('dashboard');
    
    // Управление пользователями (только admin)
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)
        ->except(['show', 'create', 'store']);
    
    // Управление играми В АДМИНКЕ
    Route::resource('games', App\Http\Controllers\Admin\GameController::class);
    
    // Управление заказами
    Route::resource('orders', App\Http\Controllers\Admin\OrderController::class)
        ->only(['index', 'show', 'destroy']);
    
});