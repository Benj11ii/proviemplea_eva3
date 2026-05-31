<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
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
 */
class Empresa extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nombre_empresa', 'rut_empresa', 'email',
        'logo_url', 'rubro', 'tipo_empresa',
        'presentacion', 'beneficios',
        'contacto_nombre', 'contacto_email', 'contacto_telefono',
        'validado', 'activo',
    ];

    protected $casts = [
        'beneficios' => 'array',
        'validado'   => 'boolean',
        'activo'     => 'boolean',
    ];

    public function contactos(): HasMany
    {
        return $this->hasMany(ContactoSolicitado::class);
    }
}

/**
 * @OA\Schema(
 *     schema="EmpresaInput",
 *     title="Empresa Input",
 *     required={"nombre_empresa", "rut_empresa", "email", "tipo_empresa"},
 *     @OA\Property(property="nombre_empresa", type="string"),
 *     @OA\Property(property="rut_empresa", type="string"),
 *     @OA\Property(property="email", type="string", format="email"),
 *     @OA\Property(property="tipo_empresa", type="string", enum={"contratacion-directa","est","outsourcing"})
 * )
 */
class EmpresaInputHelper {}