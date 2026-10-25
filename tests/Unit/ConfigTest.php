<?php

namespace Tests\Unit;

use Tests\TestCase;

class ConfigTest extends TestCase
{
    public function test_application_runs_in_testing_environment(): void
    {
        $this->assertSame('testing', app()->environment());
    }

    public function test_php_version_meets_minimum_requirement(): void
    {
        $this->assertTrue(version_compare(PHP_VERSION, '8.1.0', '>='));
    }
}
