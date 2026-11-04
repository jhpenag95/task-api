<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Función para determinar si un usuario puede ver cualquier tarea.
     */
    public function viewAny(User $user): bool
    {
        return $user->id === $user->id;
    }

    /**
     * Función para determinar si un usuario puede ver una tarea específica.
     */
    public function view(User $user, Task $task): bool
    {
        return  $user->id === $task->user_id;
    }

    /**
     * Función para determinar si un usuario puede crear una nueva tarea.
     */
    public function create(User $user): bool
    {
        return $user->id === $user->id;
    }

    /**
     * Función para determinar si un usuario puede actualizar una tarea específica.
     */
    public function update(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    /**
     * Función para determinar si un usuario puede eliminar una tarea específica.
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    /**
     * Función para determinar si un usuario puede restaurar una tarea específica.
     */
    public function restore(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }
}
