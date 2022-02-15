<?php

use App\Http\Controllers\Contracts\ContractController;
use App\Http\Controllers\Devices\DeviceController;
use App\Http\Controllers\Points\PointController;
use App\Http\Controllers\Printers\PrinterController;
use App\Http\Controllers\RemoteControls\RemoteControlController;
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

// Отключаемые пути Auth
Auth::routes([
                 'register' => false,
                 'verify' => false,
                 'reset' => false,
                 'resend' => false
             ]);

Route::group(['middleware' => 'active'], function () {
    Route::redirect('/', '/point');

    Route::group(['prefix' => 'point', 'as' => 'point.'], function () {
        Route::get('/', [PointController::class, 'index'])->name('point');
        Route::get('/{point}/{city}/view', [PointController::class, 'point'])->name('onepoint');

        Route::group(['middleware' => 'is_admin'], function () {
            Route::get('/{point}/edit', [PointController::class, 'edit'])->name('edit');
            Route::get('/new', [PointController::class, 'new'])->name('new');
            Route::post('/store', [PointController::class, 'store'])->name('store');
            Route::get('/{point}/edit', [PointController::class, 'edit'])->name('edit');
            Route::put('/update/{point}', [PointController::class, 'update'])->name('update');
            Route::get('/import-xls', [PointController::class, 'importXlsView'])->name('view-import-xls');
            Route::post('/save-xls', [PointController::class, 'saveXLS'])->name('saveXLS');
            Route::get('/{point}/close', [PointController::class, 'close'])->name('close-point');
            Route::get('/ping/{ip}', [PointController::class, 'ping']);
        });
    });

    Route::group(['prefix' => 'contract', 'as' => 'contract.'], function () {
        Route::get('/', [ContractController::class, 'index'])->name('index');

        Route::group(['middleware' => 'is_admin'], function () {
            Route::get('/create', [ContractController::class, 'create'])->name('create');
            Route::get('/{contract}/edit', [ContractController::class, 'edit'])->name('edit');
            Route::post('/', [ContractController::class, 'store'])->name('store');
            Route::put('/{contract}', [ContractController::class, 'update'])->name('update');
        });
    });

    Route::group(['middleware' => 'is_admin'], function () {
        Route::resource('/remote', RemoteControlController::class);
        Route::resource('/printer', PrinterController::class);
        Route::resource('/device', DeviceController::class);
    });

// На будущее для модулей Vue.js
//
//    Route::get('{any}', function () {
//        return view('layouts.app');
//    })->where('any', '.*');
});
