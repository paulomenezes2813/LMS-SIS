#!/usr/bin/env bash
# Railway (e outros PaaS) definem PORT; o Apache da imagem moodle-php-apache escuta 80 por padrão.
set -euo pipefail

port="${PORT:-80}"
if [[ ! "$port" =~ ^[0-9]+$ ]]; then
  echo "PORT inválido: ${port}; usando 80"
  port=80
fi

echo "Ajustando Apache para escutar na porta ${port}"

sed -i "s/^Listen .*/Listen ${port}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${port}>/" /etc/apache2/sites-available/000-default.conf
