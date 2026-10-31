<?php

namespace App\Services;

use InvalidArgumentException;

class CalculadoraPrecio
{
    public function aplicarDescuento(float $precio, float $porcentaje): float
    {
        if ($porcentaje < 0 || $porcentaje > 100) {
            throw new InvalidArgumentException('Porcentaje inválido');
        }

        return round($precio - ($precio * $porcentaje / 100), 2);
    }
}
