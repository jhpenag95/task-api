<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; //usamos el trait HasFactory para poder usar factories en el modelo; es decir, para poder crear instancias del modelo de manera sencilla y rápida, especialmente en pruebas y seeders.
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //agregando el trait SoftDeletes para habilitar soft deletes

use App\Models\User; //Aqui se importa el modelo User para poder establecer la relación entre la tarea y el usuario que la creó.

class Task extends Model
{
    use HasFactory;
    use SoftDeletes; //usando el trait SoftDeletes para habilitar soft deletes

    protected $fillable = [
        'title',
        'description',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user() //Aqui se define la relación entre la tarea y el usuario que la creó; es decir, una tarea pertenece a un usuario.
    {
        return $this->belongsTo(User::class); //Aqui se establece que una tarea pertenece a un usuario. con belongsTo() se establece la relación de muchos a uno entre el modelo Task y el modelo User.
    }
}
