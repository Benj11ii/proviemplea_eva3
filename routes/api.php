<?php

use App\Http\Controllers\AdministracionController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\PersonaController;
use Illuminate\Support\Facades\Route;

// Endpoint de salud del sistema
Route::get('/health', HealthController::class);

// Endpoints de la gestión de personas/talentos (CV Ciego)
Route::apiResource('personas', PersonaController::class);
Route::patch('personas/{persona}/validar', [PersonaController::class, 'validar']);

// Endpoints de la gestión de empresas
Route::apiResource('empresas', EmpresaController::class);
Route::patch('empresas/{empresa}/validar', [EmpresaController::class, 'validar']);

// Endpoints del módulo de Administración e Intermediación
Route::prefix('admin')->group(function () {
    Route::get('contactos',                     [AdministracionController::class, 'listarContactos']);
    Route::post('contactos',                    [AdministracionController::class, 'crearContacto']);
    Route::patch('contactos/{contacto}/estado', [AdministracionController::class, 'actualizarEstado']);
    Route::get('estadisticas',                  [AdministracionController::class, 'estadisticas']);
});