<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AreaPersonaController;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OficinaController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PersonasController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\UsuarioController;
use App\Models\AreaPersona;
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
        Route::get('/formulario/{id?}', 'getFormulario')->name('formulario');

        Route::post('/guardar', 'saveUsuario')->name('guardar');

        Route::post('/get-usuarios', 'getUsuarios')->name('get-usuarios');
        Route::post('/asignar-area', 'asignarArea')->name('asignar-area');
    });

    Route::controller(InventarioController::class)->name('inventario.')->prefix('inventario')->group(function () {
        Route::get('/', 'index')->name('index');
    });

    Route::controller(PersonasController::class)->name('personas.')->prefix('personas')->group(function () {
        Route::get('/', 'index')->name('index');

        Route::post('/get-personas', 'getAllPersonas')->name('get-personas');
        Route::get('/formulario/{id?}', 'getFormulario')->name('formulario');
        Route::post('/guardar', 'savePersona')->name('guardar');

        Route::get('/getPersonas', 'getPersonas')->name('getpersonas');
        Route::get('/getPersonasByArea/{id}', 'getPersonasByArea')->name('getPersonasByArea');

        Route::get('/getPersonasInv', 'getPersonasInv')->name('getPersonasInv');
        Route::get('/getPersonasByAreaInv/{id}', 'getPersonasByAreaInv')->name('getPersonasByAreaInv');

    });

    Route::controller(AreasController::class)->name('areas.')->prefix('areas')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/bloquear', 'bloquear')->name('bloquear');
        Route::get('/getAreas', 'getAreas')->name('getareas');
        Route::put('/asignarPersona/{id}', 'asignarPersona')->name('asignarPersona');
        Route::put('/cambiarEstado/{nro}', 'cambiarEstado')->name('cambiarEstado');
        Route::get('/getAreasByPersona/{id}', 'getAreasByPersona')->name('getAreasByPersona');
        Route::get('/getAreasByOficinaInv/{id}', 'getAreasByOficinaInv')->name('getAreasByOficinaInv');
        Route::get('/getAreasByPersonaInv/{id}', 'getAreasByPersonaInv')->name('getAreasByPersonaInv');
        Route::get('/getAreasAllInv', 'getAreasAllInv')->name('getAreasAllInv');
        Route::get('/getAreasP/{term}', 'getAreasP')->name('areasP');
    });

    Route::controller(OficinaController::class)->name('oficinas.')->prefix('oficinas')->group(function () {
        Route::get('/getallOficinas', 'getallOficinas')->name('getallOficinas');
        Route::get('/getOficinasByAreas/{id}', 'getOficinasByAreas')->name('getOficinasByAreas');
    });

    Route::controller(ReportesController::class)->name('reportes.')->prefix('reportes')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/generador', 'generador')->name('generador');
        Route::get('/explorador', 'explorador')->name('explorador');
        Route::get('/getDocuments', 'getDocuments')->name('getDocuments');
    });

    Route::controller(DocumentsController::class)->name('documentos.')->prefix('documentos')->group(function () {
        Route::get('/getDocuments', 'getDocuments')->name('getDocuments');
        Route::delete('/eliminar/{id}', 'destroy')->name('eliminarDocumento');
        Route::post('/guardar', 'saveDocument')->name('guardar');
        Route::get('/desbloquearBienes/{id}', 'desbloquearBienes')->name('desbloquearBienes');
    });

    Route::post('/generarCargos', [PDFController::class, 'genCargos'])->name('genCargos')->middleware('auth');
    Route::get('/pdfBienes/{idP}/{idArea}', [PDFController::class, 'PDFBienes'])->name('pdf-bienes');
    Route::put('/bloquear/{id}', [PDFController::class, 'bloquear'])->name('bloquear')->middleware('auth');
    Route::put('/desbloquear/{id}', [PDFController::class, 'desbloquear'])->name('desbloquear')->middleware('auth');

    Route::put('/documentos/actualizar/{idP}', [AreaPersonaController::class, 'actualizar'])->name('actualizar');
    Route::get('/getAreaPersonSelected/{idP}/{idArea}', [AreaPersonaController::class, 'getAreaPersonSelected'])->name('getAreaPersonSelected');
});

Route::middleware(['auth', 'onlyInve'])->name('inventario.')->prefix('inventario')->group(function () {

    Route::get('/', [InventarioController::class, 'viewRegistroInventario'])
        ->name('index');

    Route::get('/get-inventario/{id}', [InventarioController::class, 'getInventario'])
        ->name('get-inventario');

    Route::post('/getbienbycodigo', [InventarioController::class, 'getInventarioByCode'])
        ->name('getBien');

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



Route::middleware('auth')->name('get-data.')->prefix('get-data')->group(function () {

    Route::controller(OficinaController::class)->name('oficinas.')->prefix('oficinas')->group(function () {
        Route::get('/{term}', 'getOficinas')->name('term');
    });

    Route::controller(AreasController::class)->name('areas.')->prefix('areas')->group(function () {
        Route::get('/by-oficina/{oficina}/{usuario?}', 'getAreasByOficina')->name('by-oficina');
        Route::get('/all-info/{oficina}/{usuario?}', 'getAllInfoArea')->name('all-info');
    });
});
