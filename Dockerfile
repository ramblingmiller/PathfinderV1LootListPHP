FROM php:8.2-apache

RUN apt-get update && apt-get install -y default-mysql-client

RUN docker-php-ext-install mysqli
RUN a2enmod rewrite

COPY src/ /var/www/html/
COPY init-db.sh /init-db.sh

RUN chmod +x /init-db.sh