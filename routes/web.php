<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['preventBackHistory'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware(RedirectIfAuthenticated::class);
    Route::post('/login/store', [loginController::class, 'store'])->name('loginPost');
});

Route::get('/register', [RegisterController::class, 'index'])->name('register')->middleware(RedirectIfAuthenticated::class);
Route::post('/register/store', [registerController::class, 'store'])->name('registerPost');

Route::middleware(['auth','checkUserStatus'])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('home');
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
});
