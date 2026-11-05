<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'usuario_id',
        'accion',
        'modelo',
        'modelo_id',
        'valores_anteriores',
        'valores_nuevos',
        'descripcion',
        'direccion_ip',
        'agente_usuario',
    ];

    protected $casts = [
        'valores_anteriores' => 'array',
        'valores_nuevos' => 'array',
    ];
}