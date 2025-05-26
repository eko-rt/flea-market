<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Fortify;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;

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

Route::get('/', [ProductController::class, 'index'])->name('products.index');


Route::get('/item/{item_id}', [ProductController::class, 'show'])->name('product.show');

// いいね登録・解除
Route::post('/item/{item_id}/like', [ProductController::class, 'like'])->middleware('auth')->name('product.like');
Route::delete('/item/{item_id}/like', [ProductController::class, 'unlike'])->middleware('auth')->name('product.unlike');


// コメント投稿
Route::post('/item/{item_id}/comment', [CommentController::class, 'store'])->middleware('auth')->name('comment.store');

// 購入手続き
Route::get('/purchase/{item_id}', [PurchaseController::class, 'show'])->middleware('auth')->name('purchase.show');

Route::post('/purchase/{item_id}', [PurchaseController::class, 'store'])->middleware('auth')->name('purchase.store');


Route::get('/purchase/address/{item_id}', function($item_id) {
    $product = \App\Models\Product::findOrFail($item_id);
    return view('auth.address', compact('product'));
})->name('address.edit')->middleware('auth');

Route::post('/purchase/address/{item_id}', [ProfileController::class, 'updateAddress'])->name('address.update')->middleware('auth');