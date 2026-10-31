<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_crear_tarea_la_guarda_en_base_de_datos(): void
    {
        $this->postJson('/api/tasks', ['title' => 'Estudiar CI'])
            ->assertCreated()
            ->assertJsonPath('title', 'Estudiar CI');

        $this->assertDatabaseHas('tasks', ['title' => 'Estudiar CI']);
    }

    public function test_listar_tareas_devuelve_las_existentes(): void
    {
        Task::factory()->count(3)->create();

        $this->getJson('/api/tasks')
            ->assertOk()
            ->assertJsonCount(3);
    }
}