<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


use Laravel\Sanctum\HasApiTokens; //Aqui se agrega la clase HasApiTokens para que el modelo User pueda generar tokens de acceso para la autenticación de API.
use App\Models\Task; //Aqui se importa el modelo Task para poder establecer la relación entre el usuario y sus tareas.

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function tasks() //Aqui se define la relación entre el usuario y sus tareas; es decir, un usuario puede tener muchas tareas.
    {
        return $this->hasMany(Task::class); //Aqui se establece que un usuario puede tener muchas tareas. con hasMany() se establece la relación de uno a muchos entre el modelo User y el modelo Task.
    }
}
