<?php

namespace App\Services;

use App\Events\TaskCreated;
use App\Events\TaskDeleted;
use App\Events\TaskRestored;
use App\Events\TaskUpdated;
use App\Models\Task;
use App\Models\User;

class TaskService
{
    public function create(array $data, User $user): Task
    {
        $task = $user->tasks()->create($data); // aqui se esta creando una nueva tarea asociada al usuario autenticado. Se utiliza la relación tasks() definida en el modelo User para crear la tarea y asociarla al usuario.

        TaskCreated::dispatch($task); // aqui se esta disparando el evento TaskCreated, pasando la tarea creada como parametro.Esta en al ruta app/Events/TaskCreated.php

        return $task;
    }

    // actalizar una tarea por su id
    public function update(Task $task, array $data): Task
    {
        $valoresAnteriores = $task->toArray(); // Aqui se esta obteniendo los valores anteriores de la tarea antes de actualizarla, para poder registrarlos en el log de auditoría.

        $task->update($data);

        TaskUpdated::dispatch($task, $valoresAnteriores, $task->user_id);

        return $task->refresh(); // refresca la instancia del modelo para obtener los datos actualizados
    }

    // eliminar una tarea por su id
    public function delete(Task $task): void
    {
        $task->delete();

        TaskDeleted::dispatch($task, $task->user_id);
    }

    // restaurar una tarea por su id
    public function restore(int $id): Task
    {
        $task = Task::onlyTrashed()
            ->findOrFail($id);

        $task->restore();

        TaskRestored::dispatch($task, $task->user_id);

        return $task->fresh();
    }
}
