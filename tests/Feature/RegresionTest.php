<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegresionTest extends TestCase
{
    use RefreshDatabase;

    public function test_titulo_vacio_o_solo_espacios_no_crea_tarea(): void
    {
        $this->postJson('/api/tasks', ['title' => '   '])
            ->assertStatus(422);

        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_titulo_demasiado_largo_es_rechazado(): void
    {
        $this->postJson('/api/tasks', ['title' => str_repeat('a', 256)])
            ->assertStatus(422);
    }
}