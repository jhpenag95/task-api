<?php

namespace App\Listeners;

use App\Events\TaskRestored;
use App\Models\AuditLog;

class AuditTaskRestoredListener
{
    public function handle(TaskRestored $event): void
    {
        AuditLog::create([
            'usuario_id' => $event->usuarioId,
            'accion' => 'restored',
            'modelo' => 'Task',
            'modelo_id' => $event->task->id,
            'valores_nuevos' => $event->task->toArray(),
            'descripcion' => 'Tarea restaurada',
        ]);
    }
}
