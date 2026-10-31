#!/usr/bin/env bash
# Uso: bash scripts/perf-test.sh <url> <num_peticiones> <umbral_ms_promedio>
# Solo contra un entorno de prueba autorizado (aquí: servidor local del runner).
URL=${1:-http://127.0.0.1:8000/health}
N=${2:-50}
UMBRAL=${3:-500}
mkdir -p build
: > build/perf-raw.txt
for i in $(seq 1 "$N"); do
  curl -s -o /dev/null -w "%{time_total}\n" "$URL" >> build/perf-raw.txt
done
PROM=$(awk '{s+=$1} END {printf "%.0f", (s/NR)*1000}' build/perf-raw.txt)
P95=$(sort -n build/perf-raw.txt | awk -v n="$N" 'NR==int(n*0.95){printf "%.0f", $1*1000}')
echo "promedio_ms=$PROM" | tee build/perf.txt
echo "p95_ms=$P95" | tee -a build/perf.txt
if [ "$PROM" -gt "$UMBRAL" ]; then
  echo "FALLO: promedio ${PROM}ms supera umbral ${UMBRAL}ms"; exit 1
fi
