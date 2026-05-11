#!/usr/bin/env bash
# Exporta a base PostgreSQL do Moodle (Docker local) para um .sql pronto a importar no Railway.
# Pré-requisito: docker compose up -d (contentor lms-sis-db a correr).
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
OUT="${OUT:-$ROOT/moodle-export-for-railway.sql}"
CONTAINER="${PG_CONTAINER:-lms-sis-db}"
PG_USER="${PG_USER:-moodle}"
PG_DB="${PG_DB:-moodle}"

if ! docker info >/dev/null 2>&1; then
  echo "Erro: Docker não está acessível." >&2
  exit 1
fi

if ! docker ps --format '{{.Names}}' | grep -qx "$CONTAINER"; then
  echo "Erro: contentor '$CONTAINER' não está a correr. Executa: docker compose up -d" >&2
  exit 1
fi

echo "A exportar ${PG_DB} (utilizador ${PG_USER}) de ${CONTAINER} -> ${OUT}"

# --no-owner --no-acl: import no Railway sem conflitos de roles.
# Remove linha \restrict (pg_dump recente): clientes psql mais antigos quebram nela.
docker exec -e PGPASSWORD="${PG_PASSWORD:-moodle}" "$CONTAINER" \
  pg_dump -U "$PG_USER" --no-owner --no-acl -F p "$PG_DB" \
  | sed '/^\\restrict /d' \
  > "$OUT"

ls -lh "$OUT"
echo
echo "Próximo passo no Railway:"
echo "  1. Postgres (serviço) → Connect → copia DATABASE_URL ou PG*."
echo "  2. Na tua máquina: scripts/import-moodle-db-to-railway.sh \"\$DATABASE_URL\""
echo "  3. Depois do import, atualiza wwwroot na BD (domínio HTTPS do Railway, sem :8080)."
