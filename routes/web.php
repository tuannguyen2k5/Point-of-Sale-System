<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndexController;
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

Route::get(
    '/',
    [IndexController::class, 'index']
    );

Route::get('login',
    [LoginController::class, 'login']
    )->name('login');

Route::post('login',
    [LoginController::class, 'authenticate']
    )->name('login.authenticate');

Route::get('logout',
    [LoginController::class, 'logout']
)   ->name('logout');

Route::get('register',
    [RegisterController::class, 'show']
    )->name('register');


Route::get('user/activation/{token}', 'Auth\RegisterController@activateUser')->name('user.activate');

Route::post('register',
     [RegisterController::class, 'create']
     )->name('register.create');

Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
