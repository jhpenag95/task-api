<?php

namespace App\Services;

use App\Models\Task;
use App\Events\TaskCreated;

class TaskService
{
    public function create(array $data): Task
    {
        $task = Task::create($data);

        TaskCreated::dispatch($task); //aqui se esta disparando el evento TaskCreated, pasando la tarea creada como parametro.Esta en al ruta app/Events/TaskCreated.php

        return $task;
    }

    //actalizar una tarea por su id
    public function update(Task $task, array $data): Task
    {
        $task->update($data);
        return $task->refresh(); //refresca la instancia del modelo para obtener los datos actualizados
    }

    //eliminar una tarea por su id
    public function delete(Task $task): void
    {
        $task->delete();
    }

    //restaurar una tarea por su id
    public function restore(int $id): Task
    {
        $task = Task::onlyTrashed()
            ->findOrFail($id);

        $task->restore();

        return $task->fresh();
    }
}
