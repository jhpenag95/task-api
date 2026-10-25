<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\TaskController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/tasks', [TaskController::class, 'index']); //aqui se define la ruta oara obtner todas las tareas.

Route::post('/tasks', [TaskController::class, 'store']); //aqui se define la ruta para crear una nueva tarea.

Route::get('/tasks/{task}', [TaskController::class, 'show']); //aqui se define la ruta para obtener una tarea por su id.

Route::put('/tasks/{task}', [TaskController::class, 'update']); //aqui se define la ruta para actualizar una tarea por su id.

Route::delete('/tasks/{task}', [TaskController::class, 'destroy']); //aqui se define la ruta para eliminar una tarea por su id.

Route::post('/tasks/{id}/restore', [TaskController::class, 'restore']);//