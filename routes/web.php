<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
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

Route::get('/', [HomeController::class, 'index'])->middleware('DontEndSlashMiddleware')->name('home.index');

Route::group(['prefix' => 'service'], function () {
    Route::get('/{service:id}', [ServiceController::class, 'index'])->middleware('DontEndSlashMiddleware')->name('service.index');
    Route::get('/info/{detail:id}', [ServiceController::class, 'show'])->middleware('DontEndSlashMiddleware')->name('service.show');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
