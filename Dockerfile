# Use the latest PHP image with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install dependencies and Composer
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install required PHP extensions (example: mysqli, pdo_mysql)
RUN docker-php-ext-install mysqli pdo pdo_mysql && \
    a2enmod rewrite

# Copy your project files
COPY . /var/www/html/

# Install PHP dependencies via Composer (this will install phpdotenv)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Expose Apache's default port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
