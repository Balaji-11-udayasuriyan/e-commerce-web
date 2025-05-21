<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/register', [UserController::class, 'showRegister'])->name('register');
Route::post('/register', [UserController::class, 'register']);

Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login']);

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/carts', [CartController::class, 'index'])->name('carts');
Route::post('/add-to-cart', [CartController::class, 'addToCart']);
Route::post('/remove-from-cart', [CartController::class, 'removeFromCart']);
Route::post('/increase-quantity', [CartController::class, 'increaseQuantity']);
Route::post('/decrease-quantity', [CartController::class, 'decreaseQuantity']);
Route::post('/clear-cart', [CartController::class, 'clearCart']);

Route::get('/products', [HomeController::class])->name('products');

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

Route::get('/order/confirm', [OrderController::class, 'confirm'])->name('order.confirm');
Route::post('/order/place', [OrderController::class, 'place'])->name('order.place');
Route::get('/order/success', [OrderController::class, 'success'])->name('order.success');