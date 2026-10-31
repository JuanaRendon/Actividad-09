<?php

$total = 0;
$fail = 0;
$skip = 0;
$time = 0.0;

foreach (array_slice($argv, 1) as $file) {
    if (! is_file($file)) {
        continue;
    }
    $xml = simplexml_load_file($file);
    foreach ($xml->xpath('//testcase') as $tc) {
        $total++;
        $time += (float) $tc['time'];
        if (isset($tc->failure) || isset($tc->error)) {
            $fail++;
        } elseif (isset($tc->skipped)) {
            $skip++;
        }
    }
}

$pass = $total - $fail - $skip;
$pct = $total > 0 ? round($pass / $total * 100, 2) : 0;

echo "### Métricas de pruebas\n\n";
echo "| Métrica | Valor |\n|---|---|\n";
echo "| Total ejecutadas | $total |\n";
echo "| Aprobadas | $pass |\n";
echo "| Fallidas | $fail |\n";
echo "| Omitidas | $skip |\n";
echo "| Porcentaje aprobado | {$pct}% |\n";
echo "| Tiempo de pruebas | ".round($time, 2)." s |\n";