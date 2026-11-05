<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar migración.
     */
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {

            $table->id();

            // Usuario que realizó la acción
            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Acción realizada
            $table->string('accion');

            // Entidad afectada
            $table->string('modelo');

            // ID del registro afectado
            $table->unsignedBigInteger('modelo_id');

            // Valores anteriores
            $table->json('valores_anteriores')
                ->nullable();

            // Valores nuevos
            $table->json('valores_nuevos')
                ->nullable();

            // Descripción legible
            $table->text('descripcion')
                ->nullable();

            // Dirección IP
            $table->string('direccion_ip')
                ->nullable();

            // Cliente / navegador
            $table->text('agente_usuario')
                ->nullable();

            $table->timestamps();

            $table->index([
                'modelo',
                'modelo_id'
            ]);

            $table->index('accion');
        });
    }

    /**
     * Revertir migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
