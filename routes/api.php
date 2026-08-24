<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('post-solicitud-procesada',  [\App\Http\Controllers\Api\PostSolicitudProcesadaController::class, 'post']);

Route::post('post-solicitud-enproceso',  [\App\Http\Controllers\Api\PostSolicitudEnProcesoController::class, 'post']);

Route::post('post-email-nueva_solicitud-grupo',  [\App\Http\Controllers\Api\PostMailNuevaSolictudController::class, 'post']);

Route::post('post-email-solicitud-asignada',  [\App\Http\Controllers\Api\PostMailSolicitudAsignadaController::class, 'post']);
