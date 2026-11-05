<?php

namespace Tests\Feature;

use App\Jobs\EnviarCorreoTareaJob;
use App\Jobs\EnviarNotificacionTareaJob;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TaskAuditTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_task_creates_one_audit_log_with_correct_ids(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);
        Queue::fake([
            EnviarCorreoTareaJob::class,
            EnviarNotificacionTareaJob::class,
        ]);

        $response = $this->postJson('/api/v1/tasks', [
            'title' => 'Tarea de auditoría',
            'description' => 'Verificación de auditoría',
            'status' => 'pendiente',
        ]);

        $response->assertCreated();
        $task = Task::query()->where('title', 'Tarea de auditoría')->firstOrFail();

        $this->assertDatabaseCount('audit_logs', 1);
        $this->assertDatabaseHas('audit_logs', [
            'usuario_id' => $user->id,
            'accion' => 'created',
            'modelo' => 'Task',
            'modelo_id' => $task->id,
        ]);

        Queue::assertPushed(EnviarCorreoTareaJob::class, 1);
        Queue::assertPushed(EnviarNotificacionTareaJob::class, 1);
    }

    public function test_deleting_a_task_creates_one_audit_log_with_correct_ids(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->for($user)->create();

        Sanctum::actingAs($user);

        $response = $this->deleteJson("/api/v1/tasks/{$task->id}");

        $response->assertOk();
        $this->assertSoftDeleted($task);
        $this->assertDatabaseCount('audit_logs', 1);
        $this->assertDatabaseHas('audit_logs', [
            'usuario_id' => $user->id,
            'accion' => 'deleted',
            'modelo' => 'Task',
            'modelo_id' => $task->id,
        ]);
    }

    public function test_updating_a_task_creates_an_audit_log_with_correct_ids(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->for($user)->create();

        Sanctum::actingAs($user);

        $response = $this->putJson("/api/v1/tasks/{$task->id}", [
            'title' => 'Tarea actualizada',
        ]);

        $response->assertOk();
        $this->assertDatabaseCount('audit_logs', 1);
        $this->assertDatabaseHas('audit_logs', [
            'usuario_id' => $user->id,
            'accion' => 'updated',
            'modelo' => 'Task',
            'modelo_id' => $task->id,
        ]);
    }

    public function test_restoring_a_task_creates_an_audit_log_with_correct_ids(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->for($user)->create();
        $task->delete();

        Sanctum::actingAs($user);

        $response = $this->postJson("/api/v1/tasks/{$task->id}/restore");

        $response->assertOk();
        $this->assertNotSoftDeleted($task);
        $this->assertDatabaseCount('audit_logs', 1);
        $this->assertDatabaseHas('audit_logs', [
            'usuario_id' => $user->id,
            'accion' => 'restored',
            'modelo' => 'Task',
            'modelo_id' => $task->id,
        ]);
    }
}
