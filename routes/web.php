<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PersonasController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\UsuarioController;
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

Route::get('/', function () {
    return redirect('/login');
});



Route::get('/login', [LoginController::class, 'index'])
    ->name('index');

Route::post('/login', [LoginController::class, 'UserLogin'])
    ->name('login');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

Route::middleware(['auth', 'onlyAdmin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])
        ->name('index');

    Route::controller(UsuarioController::class)->name('usuarios.')->prefix('usuarios')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/get-usuarios', 'getUsuarios')->name('get-usuarios');
    });

    Route::controller(InventarioController::class)->name('inventario.')->prefix('inventario')->group(function () {
        Route::get('/', 'index')->name('index');
    });

    Route::controller(PersonasController::class)->name('personas.')->prefix('personas')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/getPersonas', 'getPersonas')->name('getpersonas');
        Route::get('/getPersonasByArea/{id}','getPersonasByArea')->name('getPersonasByArea');
    });
    Route::controller(AreasController::class)->name('areas.')->prefix('areas')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/bloquear', 'bloquear')->name('bloquear');
        Route::get('/getAreas', 'getAreas')->name('getareas');
        Route::put('/asignarPersona/{id}', 'asignarPersona')->name('asignarPersona');
        Route::put('/cambiarEstado/{nro}', 'cambiarEstado')->name('cambiarEstado');
        Route::get('/getAreasByPersona/{id}', 'getAreasByPersona')->name('getAreasByPersona');
    });

    Route::controller(ReportesController::class)->name('reportes.')->prefix('reportes')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/generador','generador')->name('generador');
        Route::get('/explorador','explorador')->name('explorador');
    });

    Route::post('/generarCargos', [PDFController::class, 'genCargos'])->name('genCargos')->middleware('auth');

    Route::get('/pdfBienes/{id}', [PDFController::class, 'PDFBienes'])->name('pdf-bienes');
});

Route::middleware(['auth', 'onlyInve'])->name('inventario.')->prefix('inventario')->group(function () {

    Route::get('/', [InventarioController::class, 'viewRegistroInventario'])
        ->name('index');

    Route::get('/search-personas/{term}', [InventarioController::class, 'searchPersonas'])
        ->name('search-personas');

    Route::get('/search-personas-by-id/{id}', [InventarioController::class, 'searchPersonasById'])
        ->name('search-personas-by-id');

    Route::get('/search-oficinas/{term}', [InventarioController::class, 'searchOficinas'])
        ->name('search-oficinas');

    Route::get('/search-oficina-by-id/{id}', [InventarioController::class, 'searchOficinaById'])
        ->name('search-oficina-by-area');

    Route::get('/search-areas/{oficina}', [InventarioController::class, 'searchAreas'])
        ->name('search-areas');

    Route::get('/search-codigos/{codigo}', [InventarioController::class, 'searchCodigos'])
        ->name('search-codigos');


    Route::post('/get-bienes', [InventarioController::class, 'getBienes'])
        ->name('get-bienes');

    Route::post('/guardar-inventario', [InventarioController::class, 'saveInventario'])
        ->name('guardar-inventario');
});
