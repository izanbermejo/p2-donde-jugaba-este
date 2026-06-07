<?php

namespace Tests\Feature;

use App\Models\Liga;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LigaTest extends TestCase
{
    use RefreshDatabase;


    // Comprobar que se pueden obtener todas las ligas.
    public function test_get_todas_las_ligas(): void
    {
        // Crear una liga de prueba
        Liga::create([
            'id_liga' => 'URU1',
            'nombre_liga' => 'Primera División',
            'pais_liga' => 'Uruguay',
            'dificultad_liga' => 2,
        ]);

        // Hacer la petición GET a la API
        $response = $this->getJson('/api/ligas');

        $response->assertStatus(200);

        // Comprobar que la respuesta contiene la liga creada
        $response->assertJsonFragment([
            'nombre_liga' => 'Primera División'
        ]);
    }


    // Comprobar que se puede obtener una liga utilizando el id.
    public function test_get_liga_por_id(): void
    {
        Liga::create([
            'id_liga' => 'URU1',
            'nombre_liga' => 'Primera División',
            'pais_liga' => 'Uruguay',
            'dificultad_liga' => 2,
        ]);

        $response = $this->getJson('/api/ligas/URU1');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id_liga' => 'URU1',
            'nombre_liga' => 'Primera División'
        ]);
    }


    // Comprobar que se puede crear una liga.
    public function test_crear_liga(): void
    {
        $response = $this->postJson('/api/ligas', [
            'id_liga' => 'URU1',
            'nombre_liga' => 'Primera División',
            'pais_liga' => 'Uruguay',
            'dificultad_liga' => 2,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('ligas', [
            'id_liga' => 'URU1',
            'nombre_liga' => 'Primera División',
        ]);
    }


    // Comprobar validaciones al crear una liga.
    public function test_crear_liga_validaciones_requeridos(): void
    {
        // Hacer la petición POST sin enviar ningún dato
        $response = $this->postJson('/api/ligas', []);

        // Comprobar que se devuelven errores de validación para los campos requeridos
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'id_liga',
                'nombre_liga',
                'pais_liga',
                'dificultad_liga'
            ]);
    }


    // Comprobar que la dificultad de la liga debe ser un número entre 0 y 3.
    public function test_dificultad_liga_entre_0_y_3(): void
    {
        // Hacer la petición POST con una dificultad fuera del rango permitido
        $response = $this->postJson('/api/ligas', [
            'id_liga' => 'URU1',
            'nombre_liga' => 'Primera División',
            'pais_liga' => 'Uruguay',
            'dificultad_liga' => 5,
        ]);

        // Comprobar que se devuelven errores de validación para el campo dificultad_liga
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['dificultad_liga']);
    }


    // Comprobar que se puede actualizar una liga.
    public function test_actualizar_liga(): void
    {
        Liga::create([
            'id_liga' => 'ESP1',
            'nombre_liga' => 'LaLiga',
            'pais_liga' => 'España',
            'dificultad_liga' => 1,
        ]);

        // Hacer la petición PUT para actualizar la liga
        $response = $this->putJson('/api/ligas/ESP1', [
            'nombre_liga' => 'LaLiga EA Sports',
            'pais_liga' => 'España',
            'dificultad_liga' => 2,
        ]);

        $response->assertStatus(200);

        // Comprobar que la liga se ha actualizado en la base de datos
        $this->assertDatabaseHas('ligas', [
            'id_liga' => 'ESP1',
            'nombre_liga' => 'LaLiga EA Sports',
            'dificultad_liga' => 2,
        ]);
    }


    // Comprobar que se puede eliminar una liga.
    public function test_eliminar_liga(): void
    {
        Liga::create([
            'id_liga' => 'ESP1',
            'nombre_liga' => 'LaLiga',
            'pais_liga' => 'España',
            'dificultad_liga' => 1,
        ]);

        // Hacer la petición DELETE para eliminar la liga
        $response = $this->deleteJson('/api/ligas/ESP1');

        $response->assertStatus(200);

        // Comprobar que la liga se ha eliminado de la base de datos
        $this->assertDatabaseMissing('ligas', [
            'id_liga' => 'ESP1'
        ]);
    }
}
