#!/usr/bin/env bash
# Railway (e outros PaaS) definem PORT; o Apache da imagem moodle-php-apache escuta 80 por padrão.
set -euo pipefail

# mod_php exige mpm_prefork. Em alguns hosts (ex. Railway) ficam mpm_event/worker ativos e o Apache
# morre com: AH00534: More than one MPM loaded.
if command -v a2dismod >/dev/null 2>&1; then
  echo "Apache: garantindo apenas mpm_prefork (mod_php)"
  a2dismod mpm_event 2>/dev/null || true
  a2dismod mpm_worker 2>/dev/null || true
  a2enmod mpm_prefork 2>/dev/null || true
fi

port="${PORT:-80}"
if [[ ! "$port" =~ ^[0-9]+$ ]]; then
  echo "PORT inválido: ${port}; usando 80"
  port=80
fi

echo "Ajustando Apache para escutar na porta ${port}"

sed -i "s/^Listen .*/Listen ${port}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${port}>/" /etc/apache2/sites-available/000-default.conf
