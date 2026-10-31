<?php

namespace App\Support;

use InvalidArgumentException;

class PorcentajeAprobado
{
    public static function calcular(int $aprobadas, int $total): float
    {
        if ($aprobadas < 0 || $total < 0 || $aprobadas > $total) {
            throw new InvalidArgumentException('Valores inválidos.');
        }

        if ($total === 0) {
            return 0.0;
        }

        return round(($aprobadas / $total) * 100, 2);
    }
}
