FROM php:7.2-apache
RUN a2enmod rewrite
RUN apt-get update -y && apt-get install -y libicu-dev libmariadb-dev unzip zip zlib1g-dev libpng-dev libjpeg-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev
COPY --from=composer:1.10.27 /usr/bin/composer /usr/bin/composer
RUN docker-php-ext-install mysqli pdo_mysql gd gettext