# Deploy em PaaS (ex.: Railway): PHP 8.3 + Apache, mesmo stack do docker-compose local.
FROM moodlehq/moodle-php-apache:8.3

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

WORKDIR /var/www/html

COPY docker/99-railway-apache-port.sh /docker-entrypoint.d/99-railway-apache-port.sh
RUN chmod +x /docker-entrypoint.d/99-railway-apache-port.sh

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
