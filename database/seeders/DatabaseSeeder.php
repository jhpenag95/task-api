<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //para ejeuctar esta Seeder, ejecutar el comando: php artisan db:seed 
        //php artisan migrate:fresh --seed -> para ejecutar migraciones y seeders al mismo tiempo, es decir, para crear la base de datos desde cero y llenarla con datos de prueba

        User::factory()
            ->count(5)
            ->create()
            ->each(function ($user) { //para cada usuario creado, se ejecuta la funcion anonima

                Task::factory() //aqui se crean 10 tareas para cada usuario creado
                    ->count(100)
                    ->for($user)
                    ->create();
            });


        //Crear un usuario administrador fijo ->para poder ingresar al sistema con un usuario conocido y no tener que crear uno cada vez que se ejecute el seeder
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@test.com',
            'password' => bcrypt('12345678'),
        ]);


        //crear muchas tareas para el usuario administrador fijo
        Task::factory()
            ->count(100)
            ->for(User::where('email', 'admin@test.com')->first())
            ->create();
    }
}
