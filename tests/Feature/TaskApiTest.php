<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class TaskApiTest extends TestCase
{

    //Para poder ejecutar las pruebas, se debe ejecutar el comando: php artisan test --filter TaskApiTest
    
    use RefreshDatabase;

    //Función para probar la creación de tareas a través de la API
    public function test_usuario_autenticado_puede_crear_tarea(): void
    {
        $user = User::factory()->create(); // Crear un usuario de prueba

        Sanctum::actingAs($user); // Autenticar al usuario para la prueba

        $response = $this->postJson('/api/tasks', [ //Aquí se hace la petición POST a la ruta /api/tasks con los datos de la tarea a crear
            'title' => 'Aprender Testing',
            'description' => 'Probando API',
            'status' => 'pendiente',
        ]);

        $response->assertStatus(201); // Verificar que la respuesta tenga un código de estado 201 (creado)

        $this->assertDatabaseHas('tasks', [ // Verificar que la tarea se haya creado en la base de datos
            'title' => 'Aprender Testing',
            'user_id' => $user->id,
        ]);
    }

    //Función para probar que un usuario no autenticado no puede crear tareas a través de la API
    public function test_usuario_no_autenticado_no_puede_crear_tarea(): void
    {
        $response = $this->postJson('/api/tasks', [
            'title' => 'Prueba',
            'description' => 'Prueba',
            'status' => 'pendiente',
        ]);

        $response->assertStatus(401);
    }

    //Función para probar que un usuario no puede actualizar una tarea que no le pertenece
    public function test_usuario_no_puede_actualizar_tarea_ajena(): void
    {
        $owner = User::factory()->create();

        $intruso = User::factory()->create();

        $task = Task::factory()
            ->for($owner)
            ->create();

        Sanctum::actingAs($intruso);

        $response = $this->putJson(
            "/api/tasks/{$task->id}",
            [
                'title' => 'Modificada'
            ]
        );

        $response->assertStatus(403);
    }
}
