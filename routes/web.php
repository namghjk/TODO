<?php

use App\Http\Controllers\Admin\ManagePostController;
use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\News\NewsController;
use App\Http\Controllers\User\UserInforController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\XmlConfiguration\Group;

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
    Route::post('/login/store', [loginController::class, 'store'])->name('login_post');
});

Route::get('/register', [RegisterController::class, 'index'])->name('register')->middleware(RedirectIfAuthenticated::class);
Route::post('/register/store', [registerController::class, 'store'])->name('register_post');

Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot_password');
Route::post('/forgot-password', [ForgotPasswordController::class, 'postForgetPassword'])->name('post_forget_password');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'resetPassword'])->name('reset_password');
Route::post('/reset-password', [ForgotPasswordController::class, 'postResetPassword'])->name('post_reset_password');

Route::middleware(['auth', 'checkUserStatus', 'preventBackHistory'])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('home');
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
});
Route::middleware(['auth', 'preventBackHistory'])->group(function () {
    Route::get('/user-infor/{id}', [UserInforController::class, 'index'])->name('user_infor');
    Route::post('/user-infor/{id}', [UserInforController::class, 'update'])->name('update_user_infor');

    Route::delete('/posts/delete-all', [PostController::class, 'deleteAll'])->name('delete_all_posts');

    Route::resource('posts', PostController::class);

    Route::prefix('admin')->group(function () {
        Route::resource('manage-post', ManagePostController::class);
        Route::resource('manage-user', ManageUserController::class);

        Route::delete('/manage-post/delete-all', [ManagePostController::class, 'deleteAll'])->name('delete_all_manage_posts');

        Route::get('/search', [ManagePostController::class, 'search'])->name('search');
    });
});

Route::get('/news', [NewsController::class, 'show'])->name('show');
Route::get('/news/{slug}', [NewsController::class, 'detailNews'])->name('detail_news');
