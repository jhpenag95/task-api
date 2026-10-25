<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; //usamos el trait HasFactory para poder usar factories en el modelo; es decir, para poder crear instancias del modelo de manera sencilla y rápida, especialmente en pruebas y seeders.
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //agregando el trait SoftDeletes para habilitar soft deletes

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
}
