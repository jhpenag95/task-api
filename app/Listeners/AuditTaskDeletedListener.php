<?php

namespace App\Listeners;

use App\Events\TaskDeleted;
use App\Models\AuditLog;

class AuditTaskDeletedListener
{
    public function handle(TaskDeleted $event): void
    {
        AuditLog::create([
            'usuario_id' => $event->usuarioId,
            'accion' => 'deleted',
            'modelo' => 'Task',
            'modelo_id' => $event->task->id,
            'valores_anteriores' => $event->task->toArray(),
            'descripcion' => 'Tarea eliminada',
        ]);
    }
}
