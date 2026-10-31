<?php

namespace Tests\Unit;

use App\Support\PorcentajeAprobado;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PorcentajeAprobadoTest extends TestCase
{
    public function test_18_de_20_es_90_por_ciento(): void
    {
        $this->assertSame(90.0, PorcentajeAprobado::calcular(18, 20));
    }

    public function test_todas_aprobadas_es_100(): void
    {
        $this->assertSame(100.0, PorcentajeAprobado::calcular(5, 5));
    }

    public function test_sin_pruebas_devuelve_cero(): void
    {
        $this->assertSame(0.0, PorcentajeAprobado::calcular(0, 0));
    }

    public function test_aprobadas_mayor_que_total_lanza_excepcion(): void
    {
        $this->expectException(InvalidArgumentException::class);
        PorcentajeAprobado::calcular(6, 5);
    }
}