<?php

use App\Http\Controllers\Contracts\ContractController;
use App\Http\Controllers\Points\PointController;
use App\Http\Controllers\Printers\PrinterController;
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

Route::group(['middleware' => 'auth'], function () {
    Route::redirect('/', '/point');

    Route::group(['prefix' => 'point', 'as' => 'point.'], function () {
        Route::get('/', [PointController::class, 'index'])->name('point');
        Route::get('/{point}/{city}/view', [PointController::class, 'point'])->name('onepoint');

        Route::group(['middleware' => 'is_admin'], function () {
            Route::get('/{point}/edit', [PointController::class, 'edit'])->name('edit');
            Route::get('/new', [PointController::class, 'new'])->name('new');
            Route::post('/store', [PointController::class, 'save'])->name('store');
            Route::get('/import-xls', [PointController::class, 'importXlsView'])->name('view-import-xls');
            Route::post('/save-xls', [PointController::class, 'saveXLS'])->name('saveXLS');
        });
    });

    Route::group(['prefix' => 'contract', 'as' => 'contract.'], function () {
        Route::get('/', [ContractController::class, 'list'])->name('list');

        Route::group(['middleware' => 'is_admin'], function () {
            Route::get('/new', [ContractController::class, 'new'])->name('new');
            Route::get('/{contract}/edit', [ContractController::class, 'edit'])->name('edit');
            Route::post('/store', [ContractController::class, 'save'])->name('store');
        });
    });

    Route::group(['middleware' => 'is_admin'], function () {
        Route::resource('/printer', PrinterController::class);
    });

});
