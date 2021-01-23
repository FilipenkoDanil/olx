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

Route::group(['middleware'=> 'auth'], function (){
    Route::get('/create', [\App\Http\Controllers\AdController::class, 'create'])->name('create');
    Route::post('/create-ad', [\App\Http\Controllers\AdController::class, 'store'])->name('create-ad');
});
