<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     schema="ContactoSolicitado",
 *     title="Contacto Solicitado",
 *     @OA\Property(property="id", type="string", format="uuid"),
 *     @OA\Property(property="empresa_id", type="string", format="uuid"),
 *     @OA\Property(property="persona_id", type="string", format="uuid"),
 *     @OA\Property(property="estado", type="string", enum={"pendiente","contactado","entrevista","seleccionado","no-seleccionado","proceso-cerrado"})
 * )
 */
class ContactoSolicitado extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'empresa_id', 'persona_id',
        'estado', 'notas_admin',
        'fecha_contacto', 'fecha_entrevista', 'fecha_resultado',
    ];

    protected $casts = [
        'fecha_contacto'   => 'datetime',
        'fecha_entrevista' => 'datetime',
        'fecha_resultado'  => 'datetime',
    ];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class);
    }
}

/**
 * @OA\Schema(
 *     schema="ContactoSolicitadoInput",
 *     title="Contacto Solicitado Input",
 *     required={"empresa_id", "persona_id"},
 *     @OA\Property(property="empresa_id", type="string", format="uuid"),
 *     @OA\Property(property="persona_id", type="string", format="uuid")
 * )
 */
class ContactoSolicitadoInputHelper {}