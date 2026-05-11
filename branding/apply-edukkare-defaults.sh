#!/usr/bin/env bash
# =============================================================================
# Edukkare-LMS — Aplicação dos defaults de marca no Moodle.
#
# Roda admin/cli/cfg.php para cada configuração. Idempotente: pode ser
# executado várias vezes.
#
# Uso (dentro do container ou host com PHP):
#   bash branding/apply-edukkare-defaults.sh
#
# Se rodar via docker compose:
#   docker compose exec web bash /var/www/html/branding/apply-edukkare-defaults.sh
# =============================================================================

set -euo pipefail

# Localiza a raiz do Moodle (onde está config.php). Funciona dentro e fora do container.
MOODLE_ROOT="${MOODLE_ROOT:-$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)}"

if [[ ! -f "${MOODLE_ROOT}/config.php" ]]; then
    echo "Erro: config.php não encontrado em ${MOODLE_ROOT}" >&2
    exit 1
fi

CFG="php ${MOODLE_ROOT}/public/admin/cli/cfg.php"

echo "==> Aplicando defaults Edukkare em ${MOODLE_ROOT}"

# ----------- Identidade do site -----------
$CFG --name=fullname  --set='Edukkare-LMS'
$CFG --name=shortname --set='Edukkare'
$CFG --name=summary   --set='<p>Plataforma educacional integrada — gestão acadêmica e ambiente virtual de aprendizagem em uma única experiência. Tecnologia que educa.</p>'

# ----------- Regional -----------
$CFG --name=lang             --set='pt_br'
$CFG --name=langmenu         --set='1'
$CFG --name=langlist         --set='pt_br,en,es'
$CFG --name=timezone         --set='America/Sao_Paulo'
$CFG --name=country          --set='BR'
$CFG --name=defaultcity      --set='Fortaleza'
$CFG --name=calendartype     --set='gregorian'

# ----------- Tema ativo -----------
$CFG --name=theme            --set='edukkare'
$CFG --name=allowuserthemes  --set='0'
$CFG --name=allowcoursethemes --set='0'
$CFG --name=allowcategorythemes --set='0'
$CFG --name=themedesignermode --set='0'

# ----------- Comunicação por e-mail -----------
$CFG --name=supportname  --set='Suporte Edukkare'
$CFG --name=supportemail --set='suporte@edukkare.com.br'
$CFG --name=noreplyaddress --set='nao-responda@edukkare.com.br'
# SMTP host/user/pass: defina via UI ou variáveis de ambiente seguras.

# ----------- Política de senha (req. 4.5 TER) -----------
$CFG --name=passwordpolicy           --set='1'
$CFG --name=minpasswordlength        --set='12'
$CFG --name=minpassworddigits        --set='1'
$CFG --name=minpasswordlower         --set='1'
$CFG --name=minpasswordupper         --set='1'
$CFG --name=minpasswordnonalphanum   --set='1'
$CFG --name=maximumloginattempts     --set='5'

# ----------- Privacidade / LGPD (req. 27) -----------
$CFG --name=sitepolicy        --set='https://edukkare.com.br/termos'
$CFG --name=sitepolicyguest   --set='https://edukkare.com.br/termos'
$CFG --name=sitepolicyhandler --set=''  # use plugin tool_policy quando disponível

# ----------- Performance / experiência -----------
$CFG --name=enablecourserequests --set='0'
$CFG --name=defaultpreference_maildigest --set='1'
$CFG --name=fullnamedisplay      --set='firstname lastname'
$CFG --name=enableblogs          --set='0'

echo ""
echo "==> OK. Lembre-se de purgar caches:"
echo "    php ${MOODLE_ROOT}/public/admin/cli/purge_caches.php"
echo ""
echo "==> SMTP (faltam credenciais):"
echo "    Site administration → Server → Email → Outgoing mail configuration"
