<?php

use App\Exports\UsersExports;
use App\Exports\tableExports;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AreaPersonaController;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\FacilitadorController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OficinaController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PersonasController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\UsuarioController;
use App\Mail\PruebaMail;
use App\Models\AreaPersona;
use Illuminate\Support\Facades\Mail;
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

Route::get('/offline', function () {
    return view('vendor/laravelpwa/offline');
});

/*
Route::get('/offline', [LoginController::class, 'offlineView'])
    ->name('offline');*/

// Route::post('/excel/table', function(){
//     return (new tableExports)->download('areas.xlsx');
// });
//Route::get('/export/{a},{p}', [DocumentsController::class, 'export']);

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

        Route::get('/getUsuariosAll', 'getUsuariosAll')->name('getUsuariosAll');
        Route::post('/guardar', 'saveUsuario')->name('guardar');

        Route::post('/get-usuarios', 'getUsuarios')->name('get-usuarios');
        Route::post('/asignar-area', 'asignarArea')->name('asignar-area');
    });

    Route::controller(InventarioController::class)->name('inventario.')->prefix('inventario')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/getBiens', 'getBiens')->name('getBiens');
        Route::delete('/eliminarbienadmin/{id}', 'eliminarBienAdmin')->name('eliminarBienAdmin');
        Route::post('/get-bienes-all', 'getBienesInv')->name('get-bienes-all');
        Route::get('/getBien/{id}', 'getBienInv')->name('getBienInv');
        Route::get('/getUsuarios', 'getUsuariosForInventario')->name('getUsuariosForInventario');
        
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
        Route::get('/getPersonasByAreaInvNoR/{id}', 'getPersonasByAreaInvNoR')->name('getPersonasByAreaInvNoR');
        Route::post('/savePersonasImport', 'savePersonasImport')->name('savePersonasImport');
    });

    Route::controller(GrupoController::class)->name('grupo.')->prefix('grupo')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/items-group', 'getItemsGroup')->name('items-group');
        Route::post('/guardar', 'guardarGrupo')->name('guardarGrupo');
        Route::get('/oficinas-grupo', 'getOficinasByGrupo')->name('oficinas-grupo');
        Route::get('/areas-grupo/{id}', 'getAreasOficinaByGrupo')->name('areas-grupo');
        Route::get('/usuarios-areas-grupo/{id}', 'getUsuariosByAreas')->name('usuarios-area-grupo');
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
        Route::get('/getAreasByPersonaInvNoR/{id}', 'getAreasByPersonaInvNoR')->name('getAreasByPersonaInvNoR');
        Route::get('/getAreasP/{term}', 'getAreasP')->name('areasP');
    });


    Route::controller(OficinaController::class)->name('oficinas.')->prefix('oficinas')->group(function () {
        Route::get('/getallOficinas', 'getallOficinas')->name('getallOficinas');
        Route::get('/getallOficinasG', 'getallOficinasG')->name('getOficinasG');
        Route::get('/getallOficinasDependencia', 'getallOficinasDependencia')->name('getOficinasD');
        Route::get('/getOficinasByAreas/{id}', 'getOficinasByAreas')->name('getOficinasByAreas');
    });

    Route::controller(ReportesController::class)->name('reportes.')->prefix('reportes')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/generador', 'generador')->name('generador');
        Route::get('/explorador', 'explorador')->name('explorador');
        Route::get('/getDocuments', 'getDocuments')->name('getDocuments');
        Route::get('/getDocumentsActivos', 'getDocumentsActivos')->name('getDocumentsActivos');
        Route::get('/preview/{idArea}/{idP}', 'preview')->name('preview');
        Route::get('/getDocumentsF/{e},{i},{f}', 'getDocumentsF')->name('getDocumentsF');
        Route::post('/getDocumentsF', 'getDocumentsF')->name('getDocumentsFP');

        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/avanceGlobal', 'avanceGlobal')->name('avanceGlobal');
        Route::get('/ranking', 'ranking')->name('ranking');
        Route::get('/avanceCargos', 'avanceCargos')->name('avanceCargos');
        Route::get('/regDiario', 'regDiario')->name('regDiario');
        Route::get('/regDiarioG', 'regDiarioG')->name('regDiarioG');
        Route::get('/RegXdia/{f}', 'RegXdia')->name('RegXdia');
        Route::get('/OficinasAvanzadas', 'OficinasAvanzadas')->name('OficinasAvanzadas');
        Route::get('/getCountOficina/{idO}', 'getCountOficina')->name('getCountOficina');
        Route::get('/getCountArea/{id}', 'getCountArea')->name('getCountArea');
        Route::get('/OficinasAvanzadas', 'OficinasAvanzadas')->name('OficinasAvanzadas');
        Route::get('/OficinasAvanzadasCargos', 'OficinasAvanzadasCargos')->name('OficinasAvanzadasCargos');
        Route::get('/getCountOficina/{idO}', 'getCountOficina')->name('getCountOficina');
        Route::get('/getCountArea/{id}', 'getCountArea')->name('getCountArea');
        Route::get('/getCountAreaCargos/{id}', 'getCountAreaCargos')->name('getCountAreaCargos');
        Route::get('/getCargrosByArea/{id}', 'getCargrosByArea')->name('getCargrosByArea');
    });

    Route::controller(DocumentsController::class)->name('documentos.')->prefix('documentos')->group(function () {
        Route::get('/getDocuments', 'getDocuments')->name('getDocuments');
        Route::delete('/eliminar/{id}', 'destroy')->name('eliminarDocumento');
        Route::post('/guardar', 'saveDocument')->name('guardar');
        Route::get('/desbloquearBienes/{id}', 'desbloquearBienes')->name('desbloquearBienes');
        Route::get('/excel/{a}/{p}', [UsersExports::class, 'export']);
    });
    Route::post('/generarCargos', [PDFController::class, 'genCargos'])->name('genCargos')->middleware('auth');
    Route::get('/pdfBienes/{idP}/{idArea}', [PDFController::class, 'PDFBienes'])->name('pdf-bienes');
    Route::get('/pdfBienesB/{idP}/{idArea}', [PDFController::class, 'PDFBienesBorrador'])->name('pdf-bienes-borrador');
    Route::put('/bloquear/{id}', [PDFController::class, 'bloquear'])->name('bloquear')->middleware('auth');
    Route::put('/desbloquear/{id}', [PDFController::class, 'desbloquear'])->name('desbloquear')->middleware('auth');

    Route::put('/documentos/actualizar/{idP}', [AreaPersonaController::class, 'actualizar'])->name('actualizar');
    Route::get('/getAreaPersonSelected/{idP}/{idArea}', [AreaPersonaController::class, 'getAreaPersonSelected'])->name('getAreaPersonSelected');
});

Route::middleware(['auth', 'onlyInve'])->name('inventario.')->prefix('inventario')->group(function () {

    Route::get('/', [InventarioController::class, 'viewRegistroInventario'])
        ->name('index');

    Route::get('/perfil', [InventarioController::class, 'viewPerfilInventario'])
        ->name('perfil');

    Route::post('/update-password', [InventarioController::class, 'updatePassword'])
        ->name('update-password');

    Route::get('/get-inventario/{id}', [InventarioController::class, 'getInventario'])
        ->name('get-inventario');

    Route::post('/get-bien-by-codigo', [InventarioController::class, 'getBienByCodigo'])
        ->name('get-bien-by-codigo');

    Route::post('/get-bien-by-id', [InventarioController::class, 'getBienByID'])
        ->name('get-bien-by-id');

    Route::post('/get-inventario-by-id', [InventarioController::class, 'getInventarioByID'])
        ->name('get-inventario-by-id');

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

    Route::post('/get-bienes-usuario', [InventarioController::class, 'getBienesUsuarios'])
        ->name('get-bienes-usuario');

    Route::post('/guardar-inventario', [InventarioController::class, 'saveInventario'])
        ->name('guardar-inventario');


    Route::post('/create-inventario', [InventarioController::class, 'createInventario'])
        ->name(' create-inventario');

    Route::post('/update-inventario', [InventarioController::class, 'updateInventario'])
        ->name(' update-inventario');

    Route::post('/save-foto', [InventarioController::class, 'saveFoto'])
        ->name('save-foto');


    Route::post('/delete-inventario', [InventarioController::class, 'deleteInventario'])
        ->name('delete-inventario');

    Route::get('/getTeam/{id}', [AreasController::class, 'getTeam'])->name('getTeam');
    Route::get('/getTeam/{id}', [AreasController::class, 'getTeam'])->name('getTeam');

    Route::get('/cargos', [InventarioController::class, 'viewCargosInventario'])
        ->name('cargos-inventario');

    Route::get('/getOficinas', [OficinaController::class, 'getUOficinas'])
        ->name('get-uoficinas');
    Route::get('/getPersonasByAreaInv/{id}', [PersonasController::class, 'getPersonasByAreaInv'])
        ->name('get-upersonas');

    Route::get('/preview/{iArea}/{idP}', [ReportesController::class, 'preview'])
        ->name('upreview');

    Route::get('/get-responsables/{area}', [InventarioController::class, 'getResponsablesByArea'])
        ->name('get-responsables');




});

Route::get('/oficinex', [OficinaController::class, 'getoficinex'])
->name('get-oficinex');


Route::middleware(['auth', 'onlyFacilitador'])->name('facilitador.')->prefix('facilitador')->group(function () {

    
    Route::get('/', [FacilitadorController::class, 'index'])
        ->name('index');

    Route::controller(GrupoController::class)->name('grupo.')->prefix('grupo')->group(function () {
        Route::get('/', 'indexFacilitador')->name('grupos-facilitador');
    });

    Route::controller(GrupoController::class)->name('grupo.')->prefix('grupo')->group(function () {
        Route::get('/', 'indexFacilitador')->name('grupos-facilitador');
    });

    Route::controller(InventarioController::class)->name('inventario.')->prefix('inventario')->group(function () {
        Route::get('/', 'indexFacilitador')->name('inventario-facilitador');
        Route::post('/get-bienes-all', 'getBienesInv')->name('get-bienes-all');
        Route::get('/getUsuarios', 'getUsuariosForInventario')->name('getUsuariosForInventario');
    });

    Route::controller(GrupoController::class)->name('inventario.')->prefix('inventario')->group(function () {


        Route::get('/get-grupo', 'getGrupoInv')->name('get-grupo-inv');
    });


});



Route::middleware('auth')->name('get-data.')->prefix('get-data')->group(function () {

    Route::controller(OficinaController::class)->name('oficinas.')->prefix('oficinas')->group(function () {
        Route::get('/{term}/{user?}', 'getOficinas')->name('term');
    });

    Route::controller(AreasController::class)->name('areas.')->prefix('areas')->group(function () {
        Route::get('/by-oficina/{oficina}/{usuario?}', 'getAreasByOficina')->name('by-oficina');
        Route::get('/all-info/{oficina}/{usuario?}', 'getAllInfoArea')->name('all-info');
    });
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
