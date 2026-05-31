<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
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
 */
class Persona extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'email', 'telefono', 'comprobante_residencia',
        'codigo_talento', 'resumen',
        'nivel_educacional', 'titulo_carrera', 'anio_egreso',
        'anios_experiencia', 'areas_experiencia',
        'competencias', 'rango_renta', 'tipo_jornada', 'modalidad',
        'cursos', 'idiomas', 'portafolio_url',
        'persona_discapacidad', 'validado', 'activo', 'porcentaje_completitud',
    ];

    protected $casts = [
        'areas_experiencia'   => 'array',
        'competencias'        => 'array',
        'cursos'              => 'array',
        'idiomas'             => 'array',
        'persona_discapacidad'=> 'boolean',
        'validado'            => 'boolean',
        'activo'              => 'boolean',
    ];

    public function getCvCiego(): array
    {
        return [
            'id'                   => $this->id,
            'codigo_talento'       => $this->codigo_talento,
            'resumen'              => $this->resumen,
            'nivel_educacional'    => $this->nivel_educacional,
            'titulo_carrera'       => $this->titulo_carrera,
            'anio_egreso'          => $this->anio_egreso,
            'anios_experiencia'    => $this->anios_experiencia,
            'areas_experiencia'    => $this->areas_experiencia,
            'competencias'         => $this->competencias,
            'rango_renta'          => $this->rango_renta,
            'tipo_jornada'         => $this->tipo_jornada,
            'modalidad'            => $this->modalidad,
            'cursos'               => $this->cursos,
            'idiomas'              => $this->idiomas,
            'portafolio_url'       => $this->portafolio_url,
            'persona_discapacidad' => $this->persona_discapacidad,
        ];
    }
}

/**
 * @OA\Schema(
 *     schema="PersonaInput",
 *     title="Persona Input",
 *     required={"email"},
 *     @OA\Property(property="email", type="string", format="email", example="talento@providencia.cl"),
 *     @OA\Property(property="telefono", type="string", example="+56912345678"),
 *     @OA\Property(property="nivel_educacional", type="string", enum={"basica","media","tecnica","universitaria","postgrado"})
 * )
 */
class PersonaInputHelper {}

/**
 * @OA\Schema(
 *     schema="PersonaCVCiego",
 *     title="Persona CV Ciego",
 *     @OA\Property(property="id", type="string", format="uuid"),
 *     @OA\Property(property="codigo_talento", type="string"),
 *     @OA\Property(property="resumen", type="string")
 * )
 */
class PersonaCVCiegoHelper {}