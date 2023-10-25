# Use the official PHP image from Docker Hub
FROM php:8.1-apache as web

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory in the container
WORKDIR /var/www/html

# Copy your PHP application files to the container
COPY . .

RUN composer install

EXPOSE 8000

# COPY apache-custom.conf /etc/apache2/sites-available/000-custom.conf
COPY ports.conf /etc/apache2/ports.conf
# COPY apache-custom.conf /etc/apache2/sites-available/000-default.conf

# RUN a2ensite 000-custom.conf
RUN a2enmod rewrite && service apache2 restart
# Start the Apache web server
CMD ["apache2-foreground"]
