<?php

namespace App\Services;

use InvalidArgumentException;

class PriceCalculator
{
    public function applyDiscount(float $price, float $percent): float
    {
        if ($price < 0 || $percent < 0 || $percent > 100) {
            throw new InvalidArgumentException('Valores fuera de rango');
        }

        return round($price - ($price * $percent / 100), 2);
    }
}
