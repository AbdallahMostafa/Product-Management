FROM php:8.1-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql
RUN apt-get update && apt-get upgrade -y
COPY .htaccess /var/www/html/.htaccess
RUN a2enmod rewrite && service apache2 restart