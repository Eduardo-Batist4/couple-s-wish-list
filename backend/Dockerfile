FROM php:8.3-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    && docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/app

# Copy backend files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Apache config: point DocumentRoot to /public
COPY ./apache.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80