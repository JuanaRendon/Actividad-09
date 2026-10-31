<?php

namespace Tests\Feature;

use Tests\TestCase;

class HealthTest extends TestCase
{
    public function test_home_responde_200(): void
    {
        $this->get('/')->assertStatus(200);
    }

    public function test_health_devuelve_ok_en_json(): void
    {
        $this->getJson('/health')
            ->assertStatus(200)
            ->assertJson(['status' => 'ok']);
    }

    public function test_ruta_inexistente_devuelve_404(): void
    {
        $this->get('/ruta-que-no-existe')->assertStatus(404);
    }
}
