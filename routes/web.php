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

Route::get('/advert/{id}', [\App\Http\Controllers\AdController::class, 'show'])->name('show');
Route::get('/user/profile/{user}', [\App\Http\Controllers\UserController::class, 'index'])->name('user.profile');

Route::group(['middleware'=> 'auth'], function (){
    Route::get('/create', [\App\Http\Controllers\AdController::class, 'create'])->name('create');
    Route::post('/create-ad', [\App\Http\Controllers\AdController::class, 'store'])->name('create.ad');


    Route::get('/user/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('user.update');
    Route::post('/user/{user}/addreview/', [\App\Http\Controllers\UserController::class, 'addReview'])->name('user.addreview');
});
