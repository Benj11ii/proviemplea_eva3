<?php

use App\Http\Controllers\AdministracionController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\PersonaController;
use Illuminate\Support\Facades\Route;

// Endpoint de salud del sistema
Route::get('/health', HealthController::class);

//Limitador de tasa a 30 solicitudes por minuto por IP
Route::middleware('throttle:30,1')->group(function () {
    
    Route::apiResource('personas', PersonaController::class);
    Route::patch('personas/{persona}/validar', [PersonaController::class, 'validar']);

    Route::apiResource('empresas', EmpresaController::class);
    Route::patch('empresas/{empresa}/validar', [EmpresaController::class, 'validar']);

    Route::prefix('admin')->group(function () {
        Route::get('contactos',                     [AdministracionController::class, 'listarContactos']);
        Route::post('contactos',                    [AdministracionController::class, 'crearContacto']);
        Route::patch('contactos/{contacto}/estado', [AdministracionController::class, 'actualizarEstado']);
        Route::get('estadisticas',                  [AdministracionController::class, 'estadisticas']);
    });
});