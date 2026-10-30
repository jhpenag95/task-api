 # Servicios en Laravel

Un **Service** se utiliza para organizar la lógica de negocio de la aplicación fuera de los controladores. Así, los controladores pueden enfocarse en recibir la solicitud y devolver la respuesta, mientras que el servicio realiza las operaciones necesarias.

## ¿Para qué sirve?

- Evitar que los controladores acumulen demasiada lógica.
- Reutilizar operaciones desde distintos controladores o procesos.
- Facilitar las pruebas y el mantenimiento del código.
- Agrupar una operación de negocio en un lugar claro.

Por ejemplo, un `TaskService` podría crear, actualizar o completar tareas. El controlador valida o recibe los datos, llama al servicio y devuelve la respuesta apropiada.

```php
class TaskController extends Controller
{
	public function __construct(private TaskService $taskService) {}

	public function store(Request $request)
	{
		$task = $this->taskService->create($request->validated());

		return response()->json($task, 201);
	}
}
```

Laravel puede proporcionar el servicio mediante inyección de dependencias. Un Service no es obligatorio para todas las operaciones: resulta útil cuando la lógica tiene suficiente complejidad o se comparte entre varias partes de la aplicación.
