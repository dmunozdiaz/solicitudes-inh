<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome-publico');
})->name('home-publico')->middleware(['guest:userspublic']);

//Autenticación



/**
 * Rutas para Login con Clave Unica
 */

Route::get('auth/claveunica', ['as' => 'login', 'uses' => 'App\Http\Controllers\Auth\ClaveUnicaController@redirectToProvider']);
Route::get('auth/callback/claveunica', ['as' => 'login', 'uses' => 'App\Http\Controllers\Auth\ClaveUnicaController@handleProviderCallback']);
 Route::get('auth/claveunica/logout', [\App\Http\Controllers\Auth\ClaveUnicaController::class ,'logout']);


