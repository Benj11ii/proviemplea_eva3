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

/**
 * @OA\Header(
 *     header="RateLimitLimit",
 *     description="Número máximo de peticiones permitidas por minuto (60 por defecto)",
 *     @OA\Schema(type="integer", example=60)
 * )
 *
 * @OA\Header(
 *     header="CacheControlMaxAge",
 *     description="Estrategia de caché para optimizar el rendimiento de lectura (600 segundos)",
 *     @OA\Schema(type="string", example="max-age=600, private")
 * )
 *
 * @OA\Schema(
 *     schema="Persona",
 *     title="Persona",
 *     required={"email", "codigo_talento"},
 *     @OA\Property(property="id", type="string", format="uuid", example="550e8400-e29b-41d4-a716-446655440000"),
 *     @OA\Property(property="email", type="string", format="email", example="talento@providencia.cl"),
 *     @OA\Property(property="codigo_talento", type="string", example="PROV-2026-A1B2"),
 *     @OA\Property(property="resumen", type="string", example="Desarrollador fullstack junior."),
 *     @OA\Property(property="nivel_educacional", type="string", enum={"basica","media","tecnica","universitaria","postgrado"})
 * )
 *
 * @OA\Schema(
 *     schema="PersonaInput",
 *     title="Persona Input",
 *     required={"email"},
 *     @OA\Property(property="email", type="string", format="email", example="talento@providencia.cl"),
 *     @OA\Property(property="telefono", type="string", example="+56912345678"),
 *     @OA\Property(property="nivel_educacional", type="string", enum={"basica","media","tecnica","universitaria","postgrado"})
 * )
 *
 * @OA\Schema(
 *     schema="PersonaCVCiego",
 *     title="Persona CV Ciego",
 *     @OA\Property(property="id", type="string", format="uuid"),
 *     @OA\Property(property="codigo_talento", type="string"),
 *     @OA\Property(property="resumen", type="string")
 * )
 *
 * @OA\Schema(
 *     schema="Empresa",
 *     title="Empresa",
 *     required={"nombre_empresa", "rut_empresa", "email", "tipo_empresa", "contacto_nombre", "contacto_email"},
 *     @OA\Property(property="id", type="string", format="uuid"),
 *     @OA\Property(property="nombre_empresa", type="string", example="TechCorp SpA"),
 *     @OA\Property(property="rut_empresa", type="string", example="76123456-7"),
 *     @OA\Property(property="email", type="string", format="email"),
 *     @OA\Property(property="tipo_empresa", type="string", enum={"contratacion-directa","est","outsourcing"})
 * )
 *
 * @OA\Schema(
 *     schema="EmpresaInput",
 *     title="Empresa Input",
 *     required={"nombre_empresa", "rut_empresa", "email", "tipo_empresa"},
 *     @OA\Property(property="nombre_empresa", type="string"),
 *     @OA\Property(property="rut_empresa", type="string"),
 *     @OA\Property(property="email", type="string", format="email"),
 *     @OA\Property(property="tipo_empresa", type="string", enum={"contratacion-directa","est","outsourcing"})
 * )
 *
 * @OA\Schema(
 *     schema="ContactoSolicitado",
 *     title="Contacto Solicitado",
 *     @OA\Property(property="id", type="string", format="uuid"),
 *     @OA\Property(property="empresa_id", type="string", format="uuid"),
 *     @OA\Property(property="persona_id", type="string", format="uuid"),
 *     @OA\Property(property="estado", type="string", enum={"pendiente","contactado","entrevista","seleccionado","no-seleccionado","proceso-cerrado"})
 * )
 *
 * @OA\Schema(
 *     schema="ContactoSolicitadoInput",
 *     title="Contacto Solicitado Input",
 *     required={"empresa_id", "persona_id"},
 *     @OA\Property(property="empresa_id", type="string", format="uuid"),
 *     @OA\Property(property="persona_id", type="string", format="uuid")
 * )
 */