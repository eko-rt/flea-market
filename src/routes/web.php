<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Fortify;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

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

// Fortify のビュー設定
Fortify::registerView(fn () => view('auth.register'));
Fortify::loginView(fn () => view('auth.login'));
Fortify::verifyEmailView(fn () => view('auth.verify-email'));


Route::get('/mypage/profile', function () {
    return view('auth.profile'); 
})->name('profile')->middleware('auth');

Route::get('/mypage', function () {
    return view('auth.mypage'); 
})->name('mypage')->middleware('auth');

Route::post('/logout', function () {
    auth()->logout();
    return redirect('/'); // ログアウト後に index ページへリダイレクト
})->name('logout');

Route::get('/', [ProductController::class, 'index']);

Route::get('/mylist', [ProductController::class, 'mylist'])->name('mylist');

