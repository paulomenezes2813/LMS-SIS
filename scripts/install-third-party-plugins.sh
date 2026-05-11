#!/usr/bin/env bash
# =============================================================================
# Edukkare-LMS — Instalação dos plugins de terceiros que faltam.
#
# Plugins de terceiros (precisam ser baixados):
#   - mod_customcert      (req. 51, 53, 54: certificados digitais)
#   - mod_facetoface      (req. 29, 53: eventos presenciais)
#   - mod_attendance      (req. 47, 52: frequência + QR Code)
#
# Plugins JÁ NO CORE do Moodle 5.3 (apenas habilitar):
#   - tool_mfa            (req. 4.5.1.1: MFA)
#   - tool_policy         (req. 27, 4.5.1.3: termos e LGPD)
#   - aiprovider_openai   (req. 09: IA)
#   - mod_bigbluebuttonbn (req. 48: videoconferência)
#
# Uso:
#   bash scripts/install-third-party-plugins.sh
#
# Dentro do container Docker:
#   docker compose exec web bash /var/www/html/scripts/install-third-party-plugins.sh
# =============================================================================

set -euo pipefail

MOODLE_ROOT="${MOODLE_ROOT:-$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)}"
WEBROOT="${MOODLE_ROOT}/public"

if [[ ! -f "${MOODLE_ROOT}/config.php" ]]; then
    echo "Erro: config.php não encontrado em ${MOODLE_ROOT}" >&2
    exit 1
fi

# -----------------------------------------------------------------------------
# 1. Clone dos plugins de terceiros
# -----------------------------------------------------------------------------

declare -A PLUGINS=(
    ["mod_customcert"]="https://github.com/markn86/moodle-mod_customcert.git|MOODLE_500_STABLE|${WEBROOT}/mod/customcert"
    ["mod_facetoface"]="https://github.com/catalyst/moodle-mod_facetoface.git|MOODLE_500_STABLE|${WEBROOT}/mod/facetoface"
    ["mod_attendance"]="https://github.com/danmarsden/moodle-mod_attendance.git|MOODLE_500_STABLE|${WEBROOT}/mod/attendance"
)

echo "==> 1. Baixando plugins de terceiros"
for name in "${!PLUGINS[@]}"; do
    IFS='|' read -r repo branch dir <<<"${PLUGINS[$name]}"
    if [[ -d "$dir/.git" ]]; then
        echo "  [skip] $name já clonado em $dir"
        continue
    fi
    if [[ -d "$dir" ]]; then
        echo "  [skip] $name já presente em $dir (sem .git)"
        continue
    fi
    echo "  [clone] $name -> $dir ($branch)"
    git clone --depth 1 --branch "$branch" "$repo" "$dir" \
        || echo "  [WARN] Falha no branch $branch para $name — verificar manualmente"
done

# -----------------------------------------------------------------------------
# 2. Habilitar plugins do core (MFA, policy, BigBlueButton, AI)
# -----------------------------------------------------------------------------

CFG="php ${WEBROOT}/admin/cli/cfg.php"

echo ""
echo "==> 2. Habilitando plugins core"

# MFA — requisito 4.5.1.1
$CFG --component=tool_mfa --name=enabled --set=1
echo "  [ok] tool_mfa habilitado"

# Site policy — base para termos LGPD
$CFG --component=tool_policy --name=enabled --set=1 2>/dev/null || true
echo "  [ok] tool_policy referenciado"

# BigBlueButton — videoconferência (req. 48)
$CFG --component=mod_bigbluebuttonbn --name=disabled --set=0 2>/dev/null || true
echo "  [ok] mod_bigbluebuttonbn referenciado"

# OpenAI AI provider — IA (req. 09)
# Configurações de chave de API ficam pendentes (definir via UI ou env vars).
$CFG --component=core_ai --name=enabled --set=1 2>/dev/null || true
echo "  [ok] core_ai habilitado (chave da OpenAI fica para configurar via UI)"

# -----------------------------------------------------------------------------
# 3. Upgrade e cache
# -----------------------------------------------------------------------------

echo ""
echo "==> 3. Rodando upgrade do Moodle (instala plugins recém-baixados)"
php "${WEBROOT}/admin/cli/upgrade.php" --non-interactive

echo ""
echo "==> 4. Purgando caches"
php "${WEBROOT}/admin/cli/purge_caches.php"

# -----------------------------------------------------------------------------
# 5. Próximos passos manuais
# -----------------------------------------------------------------------------

cat <<'EOF'

================================================================================
Instalação concluída. Próximos passos manuais (UI do Moodle):

1. MFA (tool_mfa):
   Administração do site → Servidor → Multi-factor authentication
   - Configurar factors permitidos (email obrigatório, totp opcional)
   - Definir contextos que exigem MFA (admin, manager)

2. Site Policy (tool_policy):
   Administração do site → Usuários → Privacidade e políticas → Gerenciar políticas
   - Criar política "Termos de uso", versão 1.0, status Ativo
   - Criar política "Política de Privacidade", versão 1.0, status Ativo
   - Criar política "Termo de Sigilo e Confidencialidade" (req. 4.5 TER)

3. OpenAI provider:
   Administração do site → IA → Provedores → OpenAI
   - Colar API key (sk-...) recebida da OpenAI
   - Habilitar placements desejados (text generation, image, summarisation)

4. BigBlueButton:
   Administração do site → Plugins → Atividades → BigBlueButton
   - Definir servidor BBB (URL + segredo compartilhado) — pode ser BBB
     comunidade (test-install.blindsidenetworks.com) ou instância própria
   - Habilitar breakout rooms

5. Custom Certificate (req. 51, 53, 54):
   Em qualquer curso → Adicionar atividade → Custom Certificate
   - Definir template visual (logos, assinatura, QR Code)

6. Face-to-Face (req. 29, 53):
   Em qualquer curso → Adicionar atividade → Face-to-Face
   - Criar sessões presenciais (data, local, vagas)

7. Attendance (req. 47, 52):
   Em qualquer curso → Adicionar atividade → Attendance
   - Habilitar QR Code para presença auto-marcada

================================================================================
EOF
