#!/usr/bin/env bash
set -euo pipefail

URL="${1:-http://127.0.0.1:8000/api/health}"
REQUESTS="${2:-200}"
CONCURRENCY="${3:-10}"
MAX_MS="${4:-300}"

case "$URL" in
  http://127.0.0.1*|http://localhost*) ;;
  *) echo "Solo se permite ejecutar la prueba contra localhost."; exit 2 ;;
esac

mkdir -p reports
ab -n "$REQUESTS" -c "$CONCURRENCY" "$URL" | tee reports/ab.txt

FAILED=$(awk '/Failed requests/ {print $3}' reports/ab.txt)
MEAN=$(grep -m1 "Time per request" reports/ab.txt | awk '{print $4}')

{
  echo "### Rendimiento (ApacheBench, $REQUESTS solicitudes, concurrencia $CONCURRENCY)"
  echo ""
  echo "| Métrica | Valor |"
  echo "|---|---|"
  echo "| Solicitudes fallidas | $FAILED |"
  echo "| Tiempo medio de respuesta | ${MEAN} ms |"
  echo "| Umbral permitido | ${MAX_MS} ms |"
} >> "${GITHUB_STEP_SUMMARY:-/dev/null}"

if [ "$FAILED" != "0" ]; then
  echo "Hubo solicitudes fallidas."; exit 1
fi
if awk -v m="$MEAN" -v x="$MAX_MS" 'BEGIN{exit !(m>x)}'; then
  echo "Tiempo medio ($MEAN ms) supera el umbral ($MAX_MS ms)."; exit 1
fi