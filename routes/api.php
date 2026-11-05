<?php

/**En este archivo se definen las rutas de la API para gestionar las tareas. */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\AuthController;


Route::prefix('v1')->group(function () { //aqui se define un grupo de rutas con el prefijo v1, para versionar la API.


    //En este primer grupo de rutas, se definen las rutas relacionadas con la autenticación de usuarios. Estas rutas permiten a los usuarios registrarse, iniciar sesión y obtener información sobre su cuenta autenticada. Todas estas rutas están agrupadas bajo el prefijo 'auth' para mantener una estructura organizada y coherente en la API.

    Route::prefix('auth')->group(function () { //aqui se define un grupo de rutas con el prefijo auth, para agrupar las rutas de autenticación.

        Route::post('/register', [AuthController::class, 'register']); //aqui se define la ruta para registrar un nuevo usuario.
        Route::post('/login', [AuthController::class, 'login']); //aqui se define la ruta para autenticar a un usuario existente.
        Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']); //aqui se define la ruta para obtener los datos del usuario autenticado mediante el token de acceso.

    });


    //En este segundo grupo de rutas, se definen las rutas relacionadas con la gestión de tareas. Estas rutas permiten a los usuarios autenticados realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) en sus tareas. Todas estas rutas están protegidas por el middleware 'auth:sanctum', lo que significa que solo los usuarios autenticados pueden acceder a ellas. Esto garantiza que cada usuario solo pueda gestionar sus propias tareas y no las de otros usuarios.

    Route::middleware('auth:sanctum')->group(function () { //aqui se define un grupo de rutas que requieren autenticación mediante tokens de acceso.

        Route::get('/tasks', [TaskController::class, 'index']); //aqui se define la ruta oara obtner todas las tareas.

        Route::post('/tasks', [TaskController::class, 'store']); //aqui se define la ruta para crear una nueva tarea.

        Route::get('/tasks/{task}', [TaskController::class, 'show']); //aqui se define la ruta para obtener una tarea por su id.

        Route::put('/tasks/{task}', [TaskController::class, 'update']); //aqui se define la ruta para actualizar una tarea por su id.

        Route::delete('/tasks/{task}', [TaskController::class, 'destroy']); //aqui se define la ruta para eliminar una tarea por su id.

        Route::post('/tasks/{id}/restore', [TaskController::class, 'restore']); //aqui se define la ruta para restaurar una tarea eliminada por su id.
    });
});



// Route::get('/user', function (Request $request) { return $request->user();})->middleware('auth:sanctum');
// Route::post('/register', [AuthController::class, 'register']); //aqui se define la ruta para registrar un nuevo usuario.
// Route::post('/login', [AuthController::class, 'login']); //aqui se define la ruta para autenticar a un usuario existente.
// Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']); //aqui se define la ruta para obtener los datos del usuario autenticado mediante el token de acceso.

// Route::middleware('auth:sanctum')->group(function () { //aqui se define un grupo de rutas que requieren autenticación mediante tokens de acceso.
//     Route::get('/tasks', [TaskController::class, 'index']); //aqui se define la ruta oara obtner todas las tareas.

//     Route::post('/tasks', [TaskController::class, 'store']); //aqui se define la ruta para crear una nueva tarea.

//     Route::get('/tasks/{task}', [TaskController::class, 'show']); //aqui se define la ruta para obtener una tarea por su id.

//     Route::put('/tasks/{task}', [TaskController::class, 'update']); //aqui se define la ruta para actualizar una tarea por su id.

//     Route::delete('/tasks/{task}', [TaskController::class, 'destroy']); //aqui se define la ruta para eliminar una tarea por su id.

//     Route::post('/tasks/{id}/restore', [TaskController::class, 'restore']); //aqui se define la ruta para restaurar una tarea eliminada por su id.
// });
