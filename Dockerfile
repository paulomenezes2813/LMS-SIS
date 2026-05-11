# Deploy em PaaS (ex.: Railway): PHP 8.3 + Apache, mesmo stack do docker-compose local.
# Builders Railway usam linux/amd64; pin evita mistura de arquitetura na pull da base.
FROM --platform=linux/amd64 moodlehq/moodle-php-apache:8.3

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

WORKDIR /var/www/html

COPY docker/99-railway-apache-port.sh /docker-entrypoint.d/99-railway-apache-port.sh
RUN chmod +x /docker-entrypoint.d/99-railway-apache-port.sh

# Ownership na cópia: menos pico de RAM/cpu que `RUN chown -R` no código Moodle (árvore muito grande).
COPY --chown=www-data:www-data . /var/www/html

EXPOSE 80
