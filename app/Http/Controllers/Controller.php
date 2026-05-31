<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "ProviEmplea API",
    description: "API REST para la plataforma de empleo ProviEmplea de Providencia. Permite gestionar talentos, empresas y procesos de selección con curriculum ciego."
)]
#[OA\Server(
    url: "http://localhost:8080/api",
    description: "Servidor de desarrollo local"
)]
#[OA\Tag(name: "Health",        description: "Endpoints de salud del sistema")]
#[OA\Tag(name: "Personas",      description: "Gestión de perfiles de talentos/vecinos")]
#[OA\Tag(name: "Empresas",      description: "Gestión de empresas empleadoras")]
#[OA\Tag(name: "Administración",description: "Gestión administrativa y seguimiento")]
abstract class Controller
{
    use ApiResponse;
}