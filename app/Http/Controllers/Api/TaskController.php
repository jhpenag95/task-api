<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest; // apuntando al servicio de tareas
use App\Http\Resources\TaskResource; // apuntando al modelo y tabla tasks
use App\Models\Task; // apuntando al request de validacion
use App\Services\TaskService; // apuntando al request de validacion
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // apuntando al resource para formatear la respuesta
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

// apuntando al trait AuthorizesRequests para poder usar el metodo authorize

class TaskController extends Controller
{
    /**
     * @var TaskService
     *                  Aqui se define una propiedad privada $taskService de tipo TaskService. Esta propiedad se utilizará para acceder a los métodos del servicio de tareas dentro del controlador.
     */
    use AuthorizesRequests; // apuntando al servicio de tareas
    // private TaskService $taskService; //definiendo la propiedad privada $taskService de tipo TaskService

    public function __construct(private TaskService $taskService) {}

    /**
     * Función para mostrar todas las tareas del usuario autenticado. Recibe un Request que contiene la información del usuario autenticado.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Task::class); // aqui se esta llamando al metodo viewAny del servicio de tareas, pasando el modelo Task para verificar si el usuario tiene permiso para ver todas las tareas

        $porPagina = min($request->query('por_pagina', 10), 100); // obteniendo el parametro por_pagina de la query string, si no existe se asigna el valor por defecto de 10

        // retornando todas las tareas formateadas con el resource
        $query = $request->user()
            ->tasks();


        //Agregar filtro por estado

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }

        //Agregar filtro por busqueda en el titulo de la tarea
        if ($request->filled('search')) {

            $query->where(
                'title',
                'like',
                '%' . $request->search . '%'
            );
        }

        $camposPermitidos = ['title', 'status', 'created_at', 'updated_at'];

        $sort = $request->query('sort', 'created_at'); // obteniendo el parametro sort de la query string, si no existe se asigna el valor por defecto de created_at, sort es el campo por el cual se ordenaran los resultados, es decir el campo por el cual se ordenaran los resultados, es decir, si se quiere ordenar por titulo, status, fecha de creacion o fecha de actualizacion

        $direction = $request->query('direccion', 'desc'); // obteniendo el parametro direccion de la query string, si no existe se asigna el valor por defecto de desc, direccion es la direccion en la cual se ordenaran los resultados, es decir, si se quiere ordenar de manera ascendente o descendente    

        if (in_array($sort, $camposPermitidos)) { // verificando si el campo por el cual se quiere ordenar es un campo permitido, es decir, si se quiere ordenar por titulo, status, fecha de creacion o fecha de actualizacion
            $sort = 'created_at';
        }

        if (! in_array($sort, $camposPermitidos)) { // verificando si el campo por el cual se quiere ordenar es un campo permitido, es decir, si se quiere ordenar por titulo, status, fecha de creacion o fecha de actualizacion
            $direction = 'desc';
        }


        // Aplicando el ordenamiento a la consulta
        $query->orderBy(
            $sort,
            $direction
        );      

        $tasks = $query->paginate($porPagina);

        return TaskResource::collection($tasks);
    }

    /**
     * Store función para crear nuevas tareas. Recibe un StoreTaskRequest que valida los datos de entrada antes de crear la tarea.
     *
     * @return JsonResponse
     */
    public function store(StoreTaskRequest $request)
    {
        $task = $this->taskService->create( // aqui se esta llamando al metodo create del servicio de tareas, pasando los datos validados del request
            $request->validated(),
            $request->user()
        );

        return response()->json([
            'mensaje' => 'Tarea creada correctamente',
            'data' => new TaskResource($task),
        ], 201);
    }

    /**
     * Función para mostrar una tarea específica. Recibe un Task que representa la tarea a mostrar.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task); // aqui se esta llamando al metodo view del servicio de tareas, pasando la tarea a mostrar

        return new TaskResource($task); // retornando la tarea formateada con el resource
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task); // aqui se esta llamando al metodo update del servicio de tareas, pasando los datos validados del request

        $task = $this->taskService->update(
            $task,
            $request->validated()
        );

        return response()->json([
            'mensaje' => 'Tarea actualizada correctamente',
            'data' => new TaskResource($task),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $this->taskService->delete($task);

        return response()->json([
            'mensaje' => 'Tarea eliminada correctamente',
        ]);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        $task = $this->taskService->restore($id);

        return response()->json([
            'mensaje' => 'Tarea restaurada correctamente',
            'data' => new TaskResource($task),
        ]);
    }
}
