<?php

use App\Http\Controllers\Inventario\InventarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;


Route::get('/holamundo', function () {
    return 'Holamundo';
});


Route::middleware('auth')->name('autocomplete.')->prefix('autocomplete')->group(function () {

    Route::controller(InventarioController::class)->name('bienes.')->prefix('bienes')->group(function () {
        Route::get('/{codigo}', 'getBienesByCode');
    });

    Route::controller(AreasController::class)->name('areas.')->prefix('areas')->group(function () {
        Route::get('/by-oficina/{oficina}/{usuario?}', 'getAreasByOficina')->name('by-oficina');
        Route::get('/all-info/{oficina}/{usuario?}', 'getAllInfoArea')->name('all-info');
    });
});
