<?php

use App\Http\Controllers\AppVersionController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\InformationAppsController;
use App\Http\Controllers\KategoriJasaController;
use App\Http\Controllers\KategoriPPOBController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', function () {
    return 'connected';
});

Route::group(['prefix' => 'v1'], function () {

    Route::get('home', [HomeController::class, 'home'])->name('home.get');
    Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard.get');

    Route::get('version', [AppVersionController::class, 'show'])->name('version.get');
    Route::post('version', [AppVersionController::class, 'store'])->name('version.add');
    Route::put('version/{id}', [AppVersionController::class, 'update'])->name('version.edit');
    Route::DELETE('version/{id}', [AppVersionController::class, 'destroy'])->name('version.delete');

    Route::get('banner', [BannerController::class, 'show'])->name('banner.get');
    Route::post('banner', [BannerController::class, 'store'])->name('banner.add');
    Route::put('banner/{id}', [BannerController::class, 'update'])->name('banner.edit');
    Route::DELETE('banner/{id}', [BannerController::class, 'destroy'])->name('banner.delete');

    Route::get('kategori_jasa', [KategoriJasaController::class, 'show'])->name('kategori_jasa.get');
    Route::post('kategori_jasa', [KategoriJasaController::class, 'store'])->name('kategori_jasa.add');
    Route::put('kategori_jasa/{id}', [KategoriJasaController::class, 'update'])->name('kategori_jasa.edit');
    Route::DELETE('kategori_jasa/{id}', [KategoriJasaController::class, 'destroy'])->name('kategori_jasa.delete');

    Route::get('kategori_ppob', [KategoriPPOBController::class, 'show'])->name('kategori_ppob.get');
    Route::post('kategori_ppob', [KategoriPPOBController::class, 'store'])->name('kategori_ppob.add');
    Route::put('kategori_ppob/{id}', [KategoriPPOBController::class, 'update'])->name('kategori_ppob.edit');
    Route::DELETE('kategori_ppob/{id}', [KategoriPPOBController::class, 'destroy'])->name('kategori_ppob.delete');

    Route::get('info', [InfoController::class, 'show'])->name('info.get');
    Route::post('info', [InfoController::class, 'store'])->name('info.add');
    Route::put('info/{id}', [InfoController::class, 'update'])->name('info.edit');
    Route::DELETE('info/{id}', [InfoController::class, 'destroy'])->name('info.delete');

    Route::get('information_apps', [InformationAppsController::class, 'show'])->name('info_app.get');
    Route::post('information_apps', [InformationAppsController::class, 'store'])->name('info_app.add');
    Route::put('information_apps/{id}', [InformationAppsController::class, 'update'])->name('info_app.edit');
    Route::DELETE('information_apps/{id}', [InformationAppsController::class, 'destroy'])->name('info_app.delete');

});
