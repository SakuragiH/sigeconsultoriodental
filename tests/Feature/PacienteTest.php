<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Paciente;
use App\Models\User;

class PacienteTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_ver_lista_de_pacientes(): void
    {
        // Crear usuario de prueba
        $usuario = User::factory()->create();

        // Crear pacientes asociados al usuario
        Paciente::factory()->count(3)->create([
            'usuario_id' => $usuario->id
        ]);

        // Petición GET autenticada a /admin/pacientes
        $response = $this->actingAs($usuario)->get('/admin/pacientes');

        // Verificar que cargue correctamente
        $response->assertStatus(200);

        // Verificar que se muestre el texto "Listado de Pacientes"
        $response->assertSee('Listado de Pacientes');

        // Verificar que se muestran los nombres de los pacientes
        $pacientes = Paciente::all();
        foreach ($pacientes as $paciente) {
            $response->assertSee($paciente->nombres);
        }
    }
}





