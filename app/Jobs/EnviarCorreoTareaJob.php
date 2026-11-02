<?php

namespace App\Jobs;

use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;


class EnviarCorreoTareaJob implements ShouldQueue
{
    use Queueable;

    public Task $task; // Agrega la propiedad $task para almacenar la tarea
    public int $tries = 3; // Número de intentos en caso de fallo
    public int $timeout = 30; // Tiempo máximo de ejecución en segundos, en este caso 30 segundos

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
        Log::info(
            'SIMULANDO ENVÍO DE CORREO',
            [
                'task_id' => $this->task->id,
                'titulo' => $this->task->title,
            ]
        );
    }
}
