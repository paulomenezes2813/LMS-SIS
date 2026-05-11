#!/usr/bin/env bash
# Importa moodle-export-for-railway.sql na base PostgreSQL do Railway.
#
# Uso:
#   export DATABASE_URL='postgresql://...'   # do Railway → Postgres → Connect
#   ./scripts/import-moodle-db-to-railway.sh
#
#   ou:
#   ./scripts/import-moodle-db-to-railway.sh 'postgresql://user:pass@host:5432/railway'
#
# Requer: psql instalado (cliente PostgreSQL).
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
SQL="${SQL:-$ROOT/moodle-export-for-railway.sql}"
URL="${1:-${DATABASE_URL:-}}"

if [[ -z "$URL" ]]; then
  echo "Uso: DATABASE_URL='postgresql://...' $0" >&2
  echo "   ou: $0 'postgresql://user:pass@host:5432/nome_bd'" >&2
  exit 1
fi

if [[ ! -f "$SQL" ]]; then
  echo "Erro: não existe '$SQL'. Gera primeiro com: ./scripts/export-moodle-db-for-railway.sh" >&2
  exit 1
fi

if ! command -v psql >/dev/null 2>&1; then
  echo "Erro: comando 'psql' não encontrado. Instala o cliente PostgreSQL (ex.: brew install libpq && brew link --force libpq)." >&2
  exit 1
fi

echo "A importar $(basename "$SQL") (isto pode demorar)..."
psql "$URL" -v ON_ERROR_STOP=1 -f "$SQL"
echo "Import concluído."
echo
echo "Atualiza o wwwroot do Moodle na BD do Railway (ajusta o domínio):"
echo "  psql \"\$DATABASE_URL\" -c \"UPDATE mdl_config SET value = 'https://TEU-SERVICO.up.railway.app' WHERE name = 'wwwroot';\""
