<?php

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

Auth::routes();

Route::get('/', [\App\Http\Controllers\AdController::class, 'index'])->name('home');
Route::get('/search', [\App\Http\Controllers\SearchController::class, 'search'])->name('search');


Route::group(['prefix' => 'advert'], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/create', [\App\Http\Controllers\AdController::class, 'create'])->name('create');
        Route::post('/create-ad', [\App\Http\Controllers\AdController::class, 'store'])->name('create.ad');
        Route::delete('/{ad}/delete', [\App\Http\Controllers\AdController::class, 'destroy'])->name('ad.destroy');
        Route::get('/{ad}/edit', [\App\Http\Controllers\AdController::class, 'edit'])->name('ad.edit');
        Route::put('/{ad}/edit', [\App\Http\Controllers\AdController::class, 'update'])->name('ad.update');
        Route::delete('/image/{image}/delete', [\App\Http\Controllers\AdController::class, 'deleteImage'])->name('image.delete');
    });
    Route::get('/{id}', [\App\Http\Controllers\AdController::class, 'show'])->name('show');
});

Route::group(['prefix' => 'user'], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
        Route::put('/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('user.update');
        Route::post('/{user}/addreview/', [\App\Http\Controllers\UserController::class, 'addReview'])->name('user.addreview');
    });
    Route::get('/{user}/profile', [\App\Http\Controllers\UserController::class, 'index'])->name('user.profile');
    Route::get('/{user}/ads', [\App\Http\Controllers\SearchController::class, 'userAds'])->name('user.ads');

});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/messages', [App\Http\Controllers\ChatController::class, 'index'])->name('messages');
    Route::get('/message/{id}', [App\Http\Controllers\ChatController::class, 'getMessage'])->name('message');
    Route::post('/message/', [App\Http\Controllers\ChatController::class, 'sendMessage'])->name('message');
});

