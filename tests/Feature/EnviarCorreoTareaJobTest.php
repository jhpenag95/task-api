<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Task; // Importa el modelo Task para poder crear una tarea de prueba
use Illuminate\Support\Facades\Queue; // Importa la clase Queue para poder simular la cola de trabajos en las pruebas


use App\Jobs\EnviarCorreoTareaJob;

class EnviarCorreoTareaJobTest extends TestCase
{
    use RefreshDatabase; // Utiliza el trait RefreshDatabase para reiniciar la base de datos entre pruebas

    /**
     * A basic feature test example.
     */
    public function test_job_es_enviado_a_la_cola(): void
    {
        Queue::fake(); // Finge la cola para evitar que los trabajos se ejecuten realmente durante la prueba

        // Crea una tarea de prueba utilizando el modelo Task
        $task = Task::create([
            'title' => 'Tarea de prueba',
            'description' => 'Probando Jobs',
            'status' => 'pendiente',
        ]);

        EnviarCorreoTareaJob::dispatch($task); // Despacha el trabajo EnviarCorreoTareaJob con la tarea de prueba

        // Verifica que el trabajo EnviarCorreoTareaJob fue enviado a la cola con la tarea correcta
        Queue::assertPushed(EnviarCorreoTareaJob::class, function ($job)  use ($task) {
            return $job->task->id === $task->id; // Compara el ID de la tarea en el trabajo con el ID de la tarea de prueba
        });
    }
}
