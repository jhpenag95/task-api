<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Jobs\TaskCreated; // Importa el evento TaskCreated, por que este listener se activará cuando se dispare ese evento
use App\Jobs\EnviarCorreoTareaJob;

class SendTaskEmailListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        EnviarCorreoTareaJob::dispatch($event->task); // Despacha el trabajo EnviarCorreoTareaJob, pasando la tarea creada como argumento. Esto permite que el trabajo se ejecute en segundo plano y envíe un correo electrónico relacionado con la tarea.
    }
}
