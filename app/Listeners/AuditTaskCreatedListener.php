<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use App\Models\AuditLog;

class AuditTaskCreatedListener
{
    public function handle(TaskCreated $event): void
    {
        AuditLog::create([
            'usuario_id' => $event->task->user_id,
            'accion' => 'created',
            'modelo' => 'Task',
            'modelo_id' => $event->task->id,
            'valores_nuevos' => $event->task->toArray(),
            'descripcion' => 'Tarea creada',
        ]);
    }
}
