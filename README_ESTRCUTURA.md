# Flujo de la arquitectura actual

La aplicación expone una API REST para administrar tareas. El siguiente diagrama refleja los flujos que están implementados actualmente:

```mermaid
flowchart TD
    Cliente["Cliente REST<br/>Solicitudes y respuestas JSON"]
    Bootstrap["bootstrap/app.php<br/>Registra routes/api.php y EventServiceProvider"]
    Rutas["Rutas API<br/>routes/api.php"]
    Controlador["TaskController"]

    Cliente --> Bootstrap --> Rutas --> Controlador

    Controlador -- "GET /api/tasks" --> Listado["Task::all()"]
    Controlador -- "GET /api/tasks/{task}" --> Binding["Route model binding"]
    Controlador -- "POST /api/tasks" --> CrearRequest["StoreTaskRequest<br/>validación"]
    Controlador -- "PUT /api/tasks/{task}" --> ActualizarRequest["UpdateTaskRequest<br/>validación"]
    Controlador -- "DELETE /api/tasks/{task}<br/>POST /api/tasks/{id}/restore" --> Servicio["TaskService"]
    CrearRequest --> Servicio
    ActualizarRequest --> Servicio

    Listado --> Modelo["Modelo Eloquent Task"]
    Binding --> Modelo
    Servicio -- "create / update / delete / restore" --> Modelo
    Modelo <--> BaseDatos[("Base de datos<br/>SQLite por defecto")]

    Servicio -- "solo al crear: TaskCreated::dispatch()" --> Evento["Evento TaskCreated"]
    Evento --> Listener["LogTaskCreated"]
    Listener --> Logs["Log de Laravel<br/>Nueva tarea creada"]

    Controlador --> Resource["TaskResource<br/>formato de la tarea"]
    Modelo --> Resource
    Resource --> Respuesta["Respuesta JSON"]
    Controlador -- "DELETE: mensaje sin TaskResource" --> Respuesta
    Respuesta --> Cliente

    Auth["GET /api/user<br/>auth:sanctum"] -. "ruta protegida independiente" .-> Rutas
```

## Resumen

- Las rutas API se registran desde `bootstrap/app.php` y conectan los endpoints de tareas con `TaskController`.
- Las solicitudes de creación y actualización se validan con sus respectivos Form Requests. El controlador consulta la lista directamente con `Task::all()`; las operaciones de creación, actualización, eliminación y restauración usan `TaskService`.
- `Task` persiste los datos mediante Eloquent. Usa soft deletes para eliminar y restaurar tareas.
- Al crear una tarea, `TaskService` despacha `TaskCreated`; `LogTaskCreated` registra sus datos en el log de Laravel.
- Las respuestas de tareas se formatean con `TaskResource`, excepto la respuesta de eliminación, que devuelve solamente un mensaje.
- La ruta `/api/user` está protegida con Sanctum y no forma parte del flujo de tareas.
