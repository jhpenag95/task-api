# ¿Para qué sirve un Event en Laravel?

Un **Event** representa algo que ocurrió en la aplicación, por ejemplo, que se creó una tarea o se registró un usuario. Se usa para comunicar ese hecho a otras partes del sistema sin mezclar sus responsabilidades.

Cuando se dispara un evento, Laravel puede ejecutar uno o varios **listeners** asociados. Por ejemplo, al crear una tarea, un listener podría enviar una notificación o guardar un registro de actividad.

```php
event(new TaskCreated($task));
```

Así, la lógica principal se mantiene separada de las acciones secundarias, y es más fácil agregar nuevas reacciones al mismo evento.
