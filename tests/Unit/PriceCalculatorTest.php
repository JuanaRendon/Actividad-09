<?php

namespace Tests\Unit;

use App\Services\PriceCalculator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PriceCalculatorTest extends TestCase
{
    public function test_aplica_descuento_correctamente(): void
    {
        $this->assertSame(90.0, (new PriceCalculator())->applyDiscount(100, 10));
    }

    public function test_descuento_cero_no_cambia_precio(): void
    {
        $this->assertSame(50.0, (new PriceCalculator())->applyDiscount(50, 0));
    }

    public function test_rechaza_porcentaje_invalido(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new PriceCalculator())->applyDiscount(100, 150);
    }
}
