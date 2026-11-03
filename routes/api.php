<?php

/**En este archivo se definen las rutas de la API para gestionar las tareas. */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']); //aqui se define la ruta para registrar un nuevo usuario.
Route::post('/login', [AuthController::class, 'login']); //aqui se define la ruta para autenticar a un usuario existente.
Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']); //aqui se define la ruta para obtener los datos del usuario autenticado mediante el token de acceso.

Route::middleware('auth:sanctum')->group(function () { //aqui se define un grupo de rutas que requieren autenticación mediante tokens de acceso.
    Route::get('/tasks', [TaskController::class, 'index']); //aqui se define la ruta oara obtner todas las tareas.

    Route::post('/tasks', [TaskController::class, 'store']); //aqui se define la ruta para crear una nueva tarea.

    Route::get('/tasks/{task}', [TaskController::class, 'show']); //aqui se define la ruta para obtener una tarea por su id.

    Route::put('/tasks/{task}', [TaskController::class, 'update']); //aqui se define la ruta para actualizar una tarea por su id.

    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']); //aqui se define la ruta para eliminar una tarea por su id.

    Route::post('/tasks/{id}/restore', [TaskController::class, 'restore']); //aqui se define la ruta para restaurar una tarea eliminada por su id.
});
