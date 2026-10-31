<?php

// Genera la tabla de métricas (indicadores.png) a partir de los JUnit y los estados de cada etapa.
$total = $fail = $skip = 0;
foreach (glob(__DIR__.'/../build/junit-*.xml') as $f) {
    $x = simplexml_load_file($f);
    $s = $x->testsuite;
    $total += (int) $s['tests'];
    $fail += (int) $s['failures'] + (int) $s['errors'];
    $skip += (int) $s['skipped'];
}
$ok = $total - $fail - $skip;
$pct = $total > 0 ? round($ok / $total * 100, 1) : 0;

$etapas = [
    'Dependencias' => getenv('S_DEPS'),
    'Análisis estático' => getenv('S_STATIC'),
    'Pruebas unitarias' => getenv('S_UNIT'),
    'Pruebas de integración' => getenv('S_FEATURE'),
    'Pruebas de rendimiento' => getenv('S_PERF'),
];
$errores = [];
foreach ($etapas as $n => $o) {
    if ($o === 'failure') {
        $errores[] = $n;
    }
}
$estado = $errores ? 'FALLIDO' : 'EXITOSO';

$perf = @parse_ini_file(__DIR__.'/../build/perf.txt') ?: [];
$resp = isset($perf['promedio_ms']) ? "{$perf['promedio_ms']} ms (p95: {$perf['p95_ms']} ms)" : 'N/D';

echo "## Métricas del pipeline\n\n| Métrica | Valor |\n|---|---|\n";
echo "| Estado de ejecución | $estado |\n";
echo '| Duración del pipeline | '.(getenv('DURACION') ?: 'N/D')." s |\n";
echo "| Pruebas aprobadas / fallidas | $ok / $fail (omitidas: $skip) |\n";
echo "| Porcentaje de pruebas aprobadas | $pct % ($ok de $total) |\n";
echo '| Errores por etapa | '.($errores ? implode(', ', $errores) : 'Ninguno')." |\n";
echo "| Tiempo de corrección | (llenar a mano: hora del fallo → hora del commit que lo corrige) |\n";
echo "| Tiempo de respuesta de la aplicación | $resp |\n";
