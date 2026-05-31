<?php

namespace Tests\Feature;

use App\Models\Persona;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonaApiTest extends TestCase
{
    use RefreshDatabase; // Resetea la base de datos temporal en cada prueba

    public function test_puede_registrar_un_talento_exitosamente()
    {
        $response = $this->postJson('/api/personas', [
            'email'             => 'test@providencia.cl',
            'telefono'          => '+56912345678',
            'nivel_educacional' => 'universitaria',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'success',
                     'data' => ['id', 'email', 'codigo_talento', 'porcentaje_completitud']
                 ]);

        $this->assertDatabaseHas('personas', [
            'email' => 'test@providencia.cl'
        ]);
    }

    public function test_no_permite_registrar_un_talento_con_email_duplicado()
    {
        // Registrar el primer usuario
        Persona::factory()->create([
            'email'          => 'duplicado@providencia.cl',
            'codigo_talento' => 'PROV-1111'
        ]);

        // Intentar registrar el segundo con el mismo email
        $response = $this->postJson('/api/personas', [
            'email' => 'duplicado@providencia.cl',
        ]);

        $response->assertStatus(422)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Los datos enviados no son válidos.'
                 ]);
    }

    public function test_la_lista_publica_expone_los_datos_en_formato_cv_ciego()
    {
        Persona::factory()->create([
            'email'          => 'secreto@providencia.cl',
            'telefono'       => '+5699999999',
            'codigo_talento' => 'PROV-2026-X1Y2',
            'resumen'        => 'Desarrollador Laravel',
            'activo'         => true
        ]);

        $response = $this->getJson('/api/personas');

        $response->assertStatus(200);
        
        // Verificar que no se expongan datos personales
        $response->assertJsonMissing(['email' => 'secreto@providencia.cl']);
        $response->assertJsonMissing(['telefono' => '+5699999999']);
    }
}