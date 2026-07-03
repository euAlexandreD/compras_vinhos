<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreateWine;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/loginSubmit', [AuthController::class, 'loginSubmit'])->name('loginSubmit');
Route::get('/', [MainController::class, 'index'])->name('index');
Route::get('/newWine', [MainController::class, 'newWine'])->name('newWine');
Route::post('/newWineSubmit', [CreateWine::class, 'newWineSubmit'])->name('newWineSubmit');
