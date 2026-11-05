<?php

namespace App\Services;

use App\Models\Task;
use App\Events\TaskCreated;
use App\Models\User;
use App\Models\AuditLog;

class TaskService
{
    public function create(array $data, User $user): Task
    {
        $task = $user->tasks()->create($data); //aqui se esta creando una nueva tarea asociada al usuario autenticado. Se utiliza la relación tasks() definida en el modelo User para crear la tarea y asociarla al usuario.

        $this->registrarAuditoria(
            $user->id,
            'created',
            'Task',
            $task->id,
            null,
            $task->toArray(),
            'Tarea creada'
        );

        TaskCreated::dispatch($task); //aqui se esta disparando el evento TaskCreated, pasando la tarea creada como parametro.Esta en al ruta app/Events/TaskCreated.php

        return $task;
    }

    //actalizar una tarea por su id
    public function update(Task $task, array $data): Task
    {
        $valoresAnteriores = $task->toArray(); //Aqui se esta obteniendo los valores anteriores de la tarea antes de actualizarla, para poder registrarlos en el log de auditoría.

        $task->update($data);

        $this->registrarAuditoria(
            auth()->id(),
            'updated',
            'Task',
            $task->id,
            $valoresAnteriores,
            $task->getChanges(),
            'Tarea actualizada'
        );

        return $task->refresh(); //refresca la instancia del modelo para obtener los datos actualizados
    }

    //eliminar una tarea por su id
    public function delete(Task $task): void
    {
        $datosEliminados = $task->toArray();

        $this->registrarAuditoria(
            auth()->id(),
            'deleted',
            'Task',
            $task->id,
            $datosEliminados,
            null,
            'Tarea eliminada'
        );
        $task->delete();
    }

    //restaurar una tarea por su id
    public function restore(int $id): Task
    {
        $task = Task::onlyTrashed()
            ->findOrFail($id);

        $task->restore();

        $this->registrarAuditoria(
            auth()->id(),
            'restored',
            'Task',
            $task->id,
            null,
            $task->toArray(),
            'Tarea restaurada'
        );

        return $task->fresh();
    }

    //Metodo para registrar un log de auditoría
    private function registrarAuditoria(
        ?int $usuarioId,
        string $accion,
        string $modelo,
        int $modeloId,
        ?array $valoresAnteriores = null,
        ?array $valoresNuevos = null,
        ?string $descripcion = null
    ): void {
        AuditLog::create([
            'usuario_id' => $usuarioId,
            'accion' => $accion,
            'modelo' => $modelo,
            'modelo_id' => $modeloId,
            'valores_anteriores' => $valoresAnteriores,
            'valores_nuevos' => $valoresNuevos,
            'descripcion' => $descripcion,
        ]);
    }
}
