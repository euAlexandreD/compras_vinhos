<?php

use App\Actions\Fortify\CreateNewUser;
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
Route::get('/editUser/{id}', [CreateUserController::class, 'editUser'])->name('editUser');
Route::post('/editUserSubmit', [CreateUserController::class, 'editUserSubmit'])->name('editUserSubmit');
