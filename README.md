# valdez_rendon_juana_IDGS102 — CI Pipeline con Laravel 10

Proyecto Laravel 10 usado para la actividad "Implementación de un CI Pipeline" (DGS 2026).
El pipeline se ejecuta con **GitHub Actions** en cada `push` y `pull_request` hacia `main`.

## Requisitos
- PHP 8.1 o superior (extensiones: mbstring, dom, fileinfo, sqlite3)
- Composer 2
- Node.js 20 y npm

## Preparar el entorno
```bash
cp .env.example .env
composer install
php artisan key:generate
npm install
```

## Verificar localmente (mismos pasos que el CI)
```bash
./scripts/verify.sh
```
O por separado:
```bash
vendor/bin/pint --test   # estilo de código
npm run build            # compilación frontend
php artisan test         # pruebas automatizadas
```

## Pipeline (`.github/workflows/ci.yml`)
```
push / pull_request (main)
  → checkout → setup PHP → caché Composer → composer install
  → .env + key:generate → Pint → setup Node → npm install → npm run build
  → php artisan test → ✅ aprobado / ❌ rechazado
```
**Criterio de aprobación:** todas las etapas terminan con código de salida 0 en cada versión de PHP de la matriz (8.1 y 8.2).
**Criterio de rechazo:** cualquier etapa falla (dependencias, estilo, build o pruebas) y el merge a `main` queda bloqueado.

## Pruebas incluidas
- `tests/Feature/HealthTest.php`: endpoint `/health` y respuesta 404.
- `tests/Feature/ExampleTest.php`: la página principal responde 200.
- `tests/Unit/ConfigTest.php`: entorno `testing` y versión mínima de PHP.

## Evidencias
Guardar capturas de la pestaña **Actions** (ejecución fallida y exitosa) en `docs/evidencias/`.
