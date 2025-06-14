<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Fortify;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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


Fortify::verifyEmailView(fn () => view('auth.verify-email'));

Route::middleware('guest')->group(function () {
    // ログインフォーム表示
    Route::get('login', [LoginController::class, 'showForm'])->name('login');
    // ログイン処理
    Route::post('login', [LoginController::class, 'login']);
});



Route::middleware('auth')->group(function () {
    // ログアウト
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // メール認証ルート
    Route::get('/email/verify', fn() => view('auth.verify-email'))
         ->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/mypage');
    })->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status','認証メール再送しました');
    })->middleware('throttle:6,1')->name('verification.send');
});


Route::get('/mypage/profile', function () {
    return view('auth.profile'); 
})->name('profile')->middleware('auth');

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

Route::get('/mypage', [ProfileController::class, 'mypage'])->name('mypage')->middleware('auth');


Route::match(['put', 'post'], '/mypage/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');

// 出品画面表示（GET）
Route::get('/sell', [SellController::class, 'create'])->name('sell.create')->middleware('auth');

// 出品処理（POST）
Route::post('/sell', [SellController::class, 'store'])->name('sell.store')->middleware('auth');
