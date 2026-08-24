<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthNewPasswordController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use App\Http\Controllers\Auth\AuthPasswordResetLinkController;
use App\Http\Controllers\Auth\AuthAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;


Route::get('/municipalidad', function (Request $rq) {
    return view('welcome', [
        'error' => $rq->error
      ]);
})->name('home-municipalidad')->middleware(['guest:web']);

Route::get('/', function () {
    return view('welcome-publico');
})->name('home-publico')->middleware(['guest:userspublic']);

//Autenticación

/**
 * Se crean metodos custom para la autenticación
 */
/*
Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
    $limiter = config('fortify.limiters.login');

    Route::post('/login', [AuthAuthenticatedSessionController::class, 'store'])->name('login.custom');
    

    Route::get('/olvido-su-contrasena', [PasswordResetLinkController::class, 'create'])
                ->middleware(['guest'])
                ->name('password.request.custom');

    Route::post('/olvido-su-contrasena', [AuthPasswordResetLinkController::class, 'store'])
            ->middleware(['guest'])
            ->name('password.email.custom');

    Route::get('/resetear-password/{token}', [NewPasswordController::class, 'create'])
            ->middleware(['guest'])
            ->name('password.reset.custom');
            
    Route::post('/resetear-password', [AuthNewPasswordController::class, 'store'])
            ->middleware(['guest'])
            ->name('password.update.custom');
});*/

Route::middleware(['auth:sanctum', 'verified', ])->group(function () {  

    //Route::get("solicitudes-ciudadanas", [\App\Http\Controllers\Solicitudes\SolicitudesCiudadanasController::class, 'list']);
    //Route::get("solicitudes-realizadas", [\App\Http\Controllers\Solicitudes\SolicitudesCiudadanasRealizadasController::class, 'list'])->name('solicitudes-realizadas');
    
    Route::get("download-file/{appuid}/{docuid}", [\App\Http\Controllers\DownloadFileController::class, 'downloadFile']);

    Route::get("download-reporte/{idreporte}/", [\App\Http\Controllers\DownloadFileController::class, 'downloadReporte']);

    Route::get("download-reporte-especial/{idreporte}/", [\App\Http\Controllers\DownloadFileController::class, 'downloadReporteEspecial']);


    Route::get("task-process/{idprocess}/", [\App\Http\Controllers\TaskController::class, 'taskprocess']);
   
    //Rutas con Login

    Route::middleware(['role:supervisor'])->group(function () {

        Route::get("dashboard", [\App\Http\Controllers\DashboardController::class, 'dashboard']);

        Route::post("dashboard/indicadores", [\App\Http\Controllers\DashboardController::class, 'indicadores']);

        Route::post("dashboard/cargar-tipo-solicitudes", [\App\Http\Controllers\DashboardController::class, 'cargarTipoSolicitudes']);
    });    

    
    Route::get("mistareas", [\App\Http\Controllers\Solicitudes\MiTareaController::class, 'list']);
    Route::get("missolicitudes", [\App\Http\Controllers\Solicitudes\BandejaMisSolicitudes\MiSolicitudController::class, 'list']);
    Route::get("supervision", [\App\Http\Controllers\Solicitudes\MiTareaController::class, 'list']);
    Route::get("historicosolicitud", [\App\Http\Controllers\Solicitudes\Proceso\HistoricoProcesoController::class, 'listCaseHistorico']);
    Route::get("documentos", [\App\Http\Controllers\Solicitudes\GestorDocumental\DocumentController::class, 'list']);
    Route::get("reportes", [\App\Http\Controllers\Solicitudes\Reportes\ReportController::class, 'list']);
    Route::get("porhacer", [\App\Http\Controllers\Solicitudes\MiTareaController::class, 'listInbox']);
    Route::get("ejecutadas", [\App\Http\Controllers\Solicitudes\MiTareaController::class, 'listParticipated']);
    Route::get("portomar", [\App\Http\Controllers\Solicitudes\MiTareaController::class, 'listUnassigned']);
    Route::get("supervisor", [\App\Http\Controllers\Solicitudes\MiTareaController::class, 'listSupervisor']);
    Route::get("solicitudes", [\App\Http\Controllers\Solicitudes\MiSolicitudController::class, 'listSolicitudes']);
    Route::get("listdocumentos", [\App\Http\Controllers\Solicitudes\GestorDocumental\DocumentController::class, 'listDocument']);


    Route::get('ingreso-solicitudes',  [\App\Http\Controllers\Solicitudes\IngresoSolicitudesController::class, 'listadoSolicitudes']);
    Route::post("agregar-solicitud-supervisor", [\App\Http\Controllers\Solicitudes\IngresoSolicitudesController::class, 'store']);
    Route::post("buscar_rut", [\App\Http\Controllers\Solicitudes\IngresoSolicitudesController::class, 'buscarRut']);
    // Route::get("nuevatarea", [\App\Http\Controllers\Solicitudes\BandejaMisSolicitudes\MiSolicitudController::class, 'new']);
    // Route::get("firmarcertificado", [\App\Http\Controllers\Solicitudes\Firmado\FirmaController::class, 'firmarDocumento']);

    Route::post("tomar-solicitud", [\App\Http\Controllers\Solicitudes\MiTareaController::class, 'tomarSolicitud']);
   
    Route::prefix('administracion')->group(function () {
        Route::middleware(['role:admin'])->group(function () {
            Route::prefix('usuarios')->group(function () {
                Route::get("/", [\App\Http\Controllers\Administrador\UsuariosController::class, 'view']);
                Route::get('listusuarios', '\App\Http\Controllers\Administrador\UsuariosController@listado')->name('administracion.usuarios.list');
                Route::get('usuariobyid', '\App\Http\Controllers\Administrador\UsuariosController@usuariobyid')->name('administracion.usuarios.usuario');

                Route::post('encargados', '\App\Http\Controllers\Administrador\UsuariosController@encargados')->name('administracion.usuarios.encargados');
                Route::post('tipsolicitudes', '\App\Http\Controllers\Administrador\UsuariosController@tipsolicitudes')->name('administracion.usuarios.tipsolicitudes');
    
                Route::post('agregar', '\App\Http\Controllers\Administrador\UsuariosController@agregar')->name('administracion.usuarios.add');
                Route::post('editar', '\App\Http\Controllers\Administrador\UsuariosController@editar')->name('administracion.usuarios.edit');
                Route::post('validadadmin', '\App\Http\Controllers\Administrador\UsuariosController@validadadmin')->name('administracion.usuarios.validadadmin');
                Route::post('validadadminedit', '\App\Http\Controllers\Administrador\UsuariosController@validadadminedit')->name('administracion.usuarios.validadadminedit');
                Route::post('deshabilitar', '\App\Http\Controllers\Administrador\UsuariosController@deshabilitar');
                Route::post('habilitar', '\App\Http\Controllers\Administrador\UsuariosController@habilitar');
            });
        });
    });

    Route::prefix('reportes')->group(function () {
        
            Route::prefix('reporte-general')->group(function () {
                Route::get("/", [\App\Http\Controllers\Reportes\ReporteGeneralController::class, 'view']);
                Route::get('listreportes', '\App\Http\Controllers\Reportes\ReporteGeneralController@listado')->name('reporte.general.list');
                Route::post('generar', '\App\Http\Controllers\Reportes\ReporteGeneralController@generarReporte');
               
            });

            Route::prefix('reporte-especifico')->group(function () {
                Route::middleware(['role:supervisor'])->group(function () {
                    Route::get("/", [\App\Http\Controllers\Reportes\ReporteEspecificoController::class, 'view']);
                    Route::get('listreportes', '\App\Http\Controllers\Reportes\ReporteEspecificoController@listado')->name('reporte.especifico.list');
                     Route::post('generar', '\App\Http\Controllers\Reportes\ReporteEspecificoController@generarReporte');
                });
                
               
            });
        
    });

    Route::get('municipalidad/auth/claveunica/logout', [\App\Http\Controllers\Auth\ClaveUnicaFuncionarioController::class ,'logout']);

    Route::post("upload-file-funcionario", [\App\Http\Controllers\UploadFileController::class, 'showUploadFile']);

});

/*Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/micuenta', ['as' => 'micuenta', 'uses' => 'App\Http\Controllers\MicuentaController@detalle']);
    Route::get('/micuenta/cambiar', ['as' => 'cambiar', 'uses' => 'App\Http\Controllers\MicuentaController@cambiar']);
    Route::post('/micuenta/cambiarpass', ['as' => 'cambiarpass', 'uses' => 'App\Http\Controllers\MicuentaController@changePass']);
  
    Route::get('/micuenta/vencida', ['as' => 'forcepass', 'uses' => 'App\Http\Controllers\MicuentaController@forcepass']);
    Route::post('/cambiarvencida', ['as' => 'forcepasschange', 'uses' => 'App\Http\Controllers\MicuentaController@forcepasschange']);
});*/



Route::middleware(['auth:userspublic'])->group(function () {
    //Route::get("solicitudes-ciudadanas", [\App\Http\Controllers\Solicitudes\SolicitudesCiudadanasController::class, 'list']);
    Route::get("solicitudes-ciudadanas", [\App\Http\Controllers\Solicitudes\SolicitudesCiudadanasController::class, 'list'])->name('solicitudes-ciudadanas');
    Route::post("agregar-solicitud-ciudadana", [\App\Http\Controllers\Solicitudes\SolicitudesCiudadanasController::class, 'store']);
    Route::get("solicitudes-realizadas", [\App\Http\Controllers\Solicitudes\SolicitudesCiudadanasRealizadasController::class, 'list'])->name('solicitudes-realizadas');
    Route::get("get-solicitude-realizada", [\App\Http\Controllers\Solicitudes\SolicitudesCiudadanasRealizadasController::class, 'get'])->name('get-solicitudes-realizadas');
    Route::post("upload-file", [\App\Http\Controllers\UploadFileController::class, 'showUploadFile']);

    Route::get('auth/claveunica/logout', [\App\Http\Controllers\Auth\ClaveUnicaController::class ,'logout']);

   
    Route::get("download-file-public/{appuid}/{docuid}", [\App\Http\Controllers\DownloadFilePublicController::class, 'downloadFile']);
});



/**
 * Rutas para Login con Clave Unica
 */

Route::get('auth/claveunica', ['as' => 'login', 'uses' => 'App\Http\Controllers\Auth\ClaveUnicaController@redirectToProvider']);
Route::get('auth/callback/claveunica', ['as' => 'login', 'uses' => 'App\Http\Controllers\Auth\ClaveUnicaController@handleProviderCallback']);


/**
 * Rutas para Login con Clave Unica Funcionario
 */

Route::get('municipalidad/auth/claveunica', ['as' => 'login', 'uses' => 'App\Http\Controllers\Auth\ClaveUnicaFuncionarioController@redirectToProvider']);
Route::get('municipalidad/auth/callback/claveunica', ['as' => 'login', 'uses' => 'App\Http\Controllers\Auth\ClaveUnicaFuncionarioController@handleProviderCallback']);
