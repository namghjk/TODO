<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserInforController;
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

Route::get('/forgotPassword', [ForgotPasswordController::class, 'index'])->name('forgotPassword');
Route::post('/forgotPassword', [ForgotPasswordController::class, 'postForgetPassword'])->name('postForgetPassword');
Route::get('/resetPassword/{token}', [ForgotPasswordController::class, 'resetPassword'])->name('resetPassword');
Route::post('/resetPassword', [ForgotPasswordController::class, 'postResetPassword'])->name('postResetPassword');

Route::middleware(['auth', 'checkUserStatus'])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('home');
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/userInfor/{id}', [UserInforController::class, 'index'])->name('userInfor');
    Route::post('/userInfor/{id}', [UserInforController::class, 'update'])->name('updateUserInfor');

    Route::resource('posts', 'App\Http\Controllers\Post\PostController');
});
