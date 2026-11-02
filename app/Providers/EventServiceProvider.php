<?php

namespace App\Providers;

use App\Events\TaskCreated;
use App\Listeners\LogTaskCreated;
use App\Listeners\SendTaskEmailListener;


use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        TaskCreated::class => [
            LogTaskCreated::class,
            SendTaskEmailListener::class, // Agrega el listener SendTaskEmailListener al evento TaskCreated
        ],
    ];
}
