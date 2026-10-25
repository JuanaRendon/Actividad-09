<?php

namespace Tests\Feature;

use Tests\TestCase;

class HealthTest extends TestCase
{
    public function test_health_endpoint_returns_ok_json(): void
    {
        $response = $this->getJson('/health');

        $response->assertStatus(200)
            ->assertJson(['status' => 'error']);
    }

    public function test_unknown_route_returns_404(): void
    {
        $this->get('/ruta-que-no-existe')->assertStatus(404);
    }
}
