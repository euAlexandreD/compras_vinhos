<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreateUserController;
use App\Http\Controllers\CreateWine;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/loginSubmit', [AuthController::class, 'loginSubmit'])->name('loginSubmit');
Route::get('/', [MainController::class, 'index'])->name('index');
Route::get('/newWine', [MainController::class, 'newWine'])->name('newWine');
Route::post('/newWineSubmit', [CreateWine::class, 'newWineSubmit'])->name('newWineSubmit');
Route::get('/createUser', [CreateUserController::class, 'newUser'])->name('newUser');
Route::post('/newUserSubmit', [CreateUserController::class, 'newUserSubmit'])->name('newUserSubmit');
Route::post('/editUserSubmit', [CreateUserController::class, 'editUserSubmit'])->name('editUserSubmit');
Route::get('/cart', [MainController::class, 'cart'])->name('cart');
Route::post('/addToCart', [MainController::class, 'addToCart'])->name('addToCart');
Route::get('/checkout', [MainController::class, 'checkout'])->name('checkout');
Route::get('/orders', [MainController::class, 'orders'])->name('orders');
Route::get('/perfil', [CreateUserController::class, 'viewPerfil'])->name('perfil');
Route::post('/cart/remove', [MainController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/clear', [MainController::class, 'clearCart'])->name('cart.clear');
Route::get('/editProduct/{id}', [MainController::class, 'editProduct'])->name('editProduct');
Route::get('/orders/pdf', [MainController::class, 'ordersPdf'])->name('orders.pdf');
