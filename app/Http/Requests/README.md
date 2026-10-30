# ¿Para qué sirven los Form Request?

Los `Form Request` en Laravel son clases que se usan para validar la información que llega en una petición HTTP, por ejemplo, desde un formulario o desde una API.

## Función principal

Permiten separar la validación de datos del controlador. En lugar de poner todas las reglas de validación dentro del método `store()` o `update()`, se crean clases específicas para cada tipo de petición.

## ¿Qué hacen?

- Verifican que los datos enviados cumplen ciertas reglas.
- Rechazan la petición automáticamente si faltan campos o tienen valores inválidos.
- Devuelven mensajes de error estándar de validación.
- Mantienen el código del controlador más limpio y ordenado.

## Ventajas

- Mejor legibilidad del código.
- Menos lógica mezclada en los controladores.
- Reutilización de reglas de validación.
- Organización más clara en proyectos grandes.
- Facilitan el manejo de validaciones complejas.

## Ejemplo básico

```php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'boolean',
        ];
    }
}
```

Y luego en el controlador:

```php
public function store(StoreTaskRequest $request)
{
    $data = $request->validated();

    // guardar la tarea
}
```

## En resumen

Los `Form Request` sirven para validar datos de entrada de manera ordenada y centralizada, evitando que el controlador tenga demasiada responsabilidad y ayudando a mantener el proyecto más limpio y profesional.
