<?php

namespace Database\Seeders;

use App\Models\Empresa;
use App\Models\Persona;
use App\Models\ContactoSolicitado;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Sembrar la base de datos con tus datos de prueba reales de la guía.
     */
    public function run(): void
    {
        // 1. Crear el Talento de Prueba (Persona en formato CV Ciego)
        $persona = Persona::create([
            'email'                => 'talento@ejemplo.cl',
            'telefono'             => '+56912345678',
            'codigo_talento'       => 'PROV-2026-A1B2',
            'resumen'              => 'Profesional con experiencia en desarrollo web.',
            'nivel_educacional'    => 'universitaria',
            'titulo_carrera'       => 'Ingeniería Informática',
            'anio_egreso'          => 2020,
            'anios_experiencia'    => 5,
            'areas_experiencia'    => ['Desarrollo Web', 'APIs REST'],
            'competencias'         => ['PHP', 'Laravel', 'MySQL', 'Docker'],
            'rango_renta'          => '800k-1.2M',
            'tipo_jornada'         => 'completa',
            'modalidad'            => 'hibrido',
            'persona_discapacidad' => false,
            'validado'             => true,
            'activo'               => true,
            'porcentaje_completitud'=> 100,
        ]);

        // 2. Crear la Empresa de Prueba
        $empresa = Empresa::create([
            'nombre_empresa'    => 'TechCorp SpA',
            'rut_empresa'       => '76123456-7',
            'email'             => 'rrhh@techcorp.cl',
            'tipo_empresa'      => 'contratacion-directa',
            'rubro'             => 'Tecnología',
            'contacto_nombre'   => 'Ana López',
            'contacto_email'    => 'ana@techcorp.cl',
            'contacto_telefono' => '+56987654321',
            'beneficios'        => ['Seguro complementario', 'Trabajo remoto', 'Capacitaciones'],
            'validado'          => true,
            'activo'            => true,
        ]);

        // 3. Crear el registro de Intermediación Administrativa de prueba
        ContactoSolicitado::create([
            'empresa_id'  => $empresa->id,
            'persona_id'  => $persona->id,
            'estado'      => 'pendiente',
            'notas_admin' => 'Empresa interesada en el perfil de desarrollo backend.',
        ]);
    }
}