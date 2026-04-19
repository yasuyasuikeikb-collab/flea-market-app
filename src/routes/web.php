<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseAddressController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;

use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

// 商品一覧（トップ）
Route::get('/', [ItemController::class, 'index'])->name('items.index');

// 商品詳細
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('items.show');

// 会員登録
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// ログイン
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);


/*
|--------------------------------------------------------------------------
| Auth Required
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // ログアウト
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // 商品購入
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'store'])->name('purchase.store');

    // 送付先住所変更
    Route::get('/purchase/address/{item_id}', [PurchaseAddressController::class, 'edit'])->name('purchase.address.edit');
    Route::post('/purchase/address/{item_id}', [PurchaseAddressController::class, 'update'])->name('purchase.address.update');

    // 商品出品
    Route::get('/sell', [SellController::class, 'create'])->name('sell.create');
    Route::post('/sell', [SellController::class, 'store'])->name('sell.store');

    // プロフィール（マイページ）
    Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage.index');

    // プロフィール編集
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');

    // いいね
    Route::post('/item/{item_id}/like', [LikeController::class, 'store'])->name('like.store');
    Route::delete('/item/{item_id}/like', [LikeController::class, 'destroy'])->name('like.destroy');

    // コメント
    Route::post('/item/{item_id}/comment', [CommentController::class, 'store'])->name('comment.store');
});