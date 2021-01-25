<?php

use App\Http\Controllers\BlogController;
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
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('/', [HomeController::class, 'index'])->middleware('DontEndSlashMiddleware')->name('home.index');

Route::group(['prefix' => 'blog'], function () {
    Route::get('/', [BlogController::class, 'all'])->middleware('DontEndSlashMiddleware')->name('blog.all');
    Route::get('/{blog:id}', [BlogController::class, 'index'])->middleware('DontEndSlashMiddleware')->name('blog.index');
    Route::get('/info/{post:id}', [BlogController::class, 'show'])->middleware('DontEndSlashMiddleware')->name('blog.show');
    Route::get('/tag/{tag:id}', [BlogController::class, 'tag'])->middleware('DontEndSlashMiddleware')->name('blog.tag');
});

Route::group(['prefix' => 'service'], function () {
    Route::get('/{service:id}', [ServiceController::class, 'index'])->middleware('DontEndSlashMiddleware')->name('service.index');
    Route::get('/info/{detail:id}', [ServiceController::class, 'show'])->middleware('DontEndSlashMiddleware')->name('service.show');
});
