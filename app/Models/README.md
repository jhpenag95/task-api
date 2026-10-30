# ¿Para qué sirve un Model en Laravel?

Un `Model` en Laravel representa una tabla de la base de datos y sirve como una capa para interactuar con ella usando Eloquent.

## Función principal

Permite trabajar con los datos de una tabla sin escribir consultas SQL manualmente. Con un modelo puedes:

- Consultar registros
- Insertar nuevos datos
- Actualizar información
- Eliminar registros
- Definir relaciones entre tablas
- Organizar la lógica de acceso a datos

## Ejemplo

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'description',
        'completed',
    ];
}
```

Con este modelo puedes hacer cosas como:

```php
$tasks = Task::all();

$task = Task::find(1);

Task::create([
    'title' => 'Aprender Laravel',
    'description' => 'Estudiar modelos y migraciones',
    'completed' => false,
]);
```

## En resumen

Un `Model` es la representación de una entidad de tu aplicación en la base de datos. Sirve para manejar los datos de forma ordenada, limpia y reutilizable.

En Laravel, el `Model` es el corazón del ORM Eloquent.
