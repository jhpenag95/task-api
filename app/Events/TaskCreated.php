<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Task;


class TaskCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels; //traits que permiten despachar el evento, interactuar con sockets y serializar modelos

    public Task $task; //propiedad publica para almacenar la tarea creada

    /**
     * Create a new event instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task; //asignando la tarea creada a la propiedad publica
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
