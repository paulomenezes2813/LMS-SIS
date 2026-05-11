# Deploy em PaaS (ex.: Railway): PHP 8.3 + Apache, mesmo stack do docker-compose local.
# Não usar FROM --platform=... constante: o builder do Railway acusa FromPlatformFlagConstDisallowed.
FROM moodlehq/moodle-php-apache:8.3

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

WORKDIR /var/www/html

COPY docker/99-railway-apache-port.sh /docker-entrypoint.d/99-railway-apache-port.sh
RUN chmod +x /docker-entrypoint.d/99-railway-apache-port.sh

# Ownership na cópia: menos pico de RAM/cpu que `RUN chown -R` no código Moodle (árvore muito grande).
COPY --chown=www-data:www-data . /var/www/html

# Evita AH00534 "More than one MPM loaded" em ambientes onde vários MPM ficam em mods-enabled.
RUN a2dismod mpm_event 2>/dev/null || true \
    && a2dismod mpm_worker 2>/dev/null || true \
    && a2enmod mpm_prefork

EXPOSE 80
