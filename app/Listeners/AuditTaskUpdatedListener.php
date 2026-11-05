<?php

namespace App\Listeners;

use App\Events\TaskUpdated;
use App\Models\AuditLog;

class AuditTaskUpdatedListener
{
    public function handle(TaskUpdated $event): void
    {
        AuditLog::create([
            'usuario_id' => $event->usuarioId,
            'accion' => 'updated',
            'modelo' => 'Task',
            'modelo_id' => $event->task->id,
            'valores_anteriores' => $event->valoresAnteriores,
            'valores_nuevos' => $event->task->fresh()->toArray(),
            'descripcion' => 'Tarea actualizada',
        ]);
    }
}
