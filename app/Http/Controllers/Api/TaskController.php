<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\TaskService; //apuntando al servicio de tareas

use App\Models\Task; //apuntando al modelo y tabla tasks
use App\Http\Requests\StoreTaskRequest; //apuntando al request de validacion
use App\Http\Requests\UpdateTaskRequest; //apuntando al request de validacion
use App\Http\Resources\TaskResource; //apuntando al resource para formatear la respuesta

class TaskController extends Controller
{

    /**
     * @var TaskService
     * Aqui se define una propiedad privada $taskService de tipo TaskService. Esta propiedad se utilizará para acceder a los métodos del servicio de tareas dentro del controlador.
     */

    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //retornando todas las tareas formateadas con el resource
        return TaskResource::collection(
            Task::all()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $task = $this->taskService->create( //aqui se esta llamando al metodo create del servicio de tareas, pasando los datos validados del request
            $request->validated()
        );

        return response()->json([
            'mensaje' => 'Tarea creada correctamente',
            'data' => new TaskResource($task)
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return new TaskResource($task); //retornando la tarea formateada con el resource
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task = $this->taskService->update(
            $task,
            $request->validated()
        );

        return response()->json([
            'mensaje' => 'Tarea actualizada correctamente',
            'data' => new TaskResource($task)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->taskService->delete($task);

        return response()->json([
            'mensaje' => 'Tarea eliminada correctamente'
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
            'data' => new TaskResource($task)
        ]);
    }
}
