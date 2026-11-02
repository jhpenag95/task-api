<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use App\Models\Task;
use Illuminate\Support\Facades\Log;


class EnviarNotificacionTareaJob implements ShouldQueue
{
    use Queueable; // Agrega la interfaz ShouldQueue para que el trabajo se ejecute en segundo plano

    public int $tries = 3; // Número de intentos en caso de fallo
    public int $timeout = 30; // Tiempo máximo de ejecución en segundos, en este caso 30 segundos
    public int $backoff = 10; // Tiempo de espera entre intentos en segundos, en este caso 10 segundos


    public Task $task; // Agrega la propiedad $task para almacenar la tarea

    /**
     * Create a new job instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task; // Asigna la tarea al crear el trabajo
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        // Simula un fallo para probar la reintentos y el manejo de errores
        // throw new \Exception(
        //     'Fallo forzado para pruebas'
        // );
        Log::info('Enviando notificación para la tarea: ' . $this->task->id); // Aquí puedes agregar la lógica para enviar la notificación, por ejemplo, enviar un correo electrónico o una notificación push.

    }
}
