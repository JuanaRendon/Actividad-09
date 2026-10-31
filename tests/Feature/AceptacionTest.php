<?php

namespace Tests\Feature;

use Tests\TestCase;

class AceptacionTest extends TestCase
{
    public function test_la_pagina_principal_carga(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_health_check_responde_ok(): void
    {
        $this->getJson('/api/health')
            ->assertOk()
            ->assertExactJson(['status' => 'ok']);
    }
}