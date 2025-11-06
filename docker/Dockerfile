FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    mysql-client \
    nodejs \
    npm \
    oniguruma-dev \
    redis \
    autoconf \
    g++ \
    make \
    linux-headers \
    netcat-openbsd

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    sockets

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first (for better Docker layer caching)
COPY composer.json composer.lock ./

# Install dependencies (skip scripts since artisan doesn't exist yet)
# For development, we keep dev dependencies, remove --no-dev if needed
RUN composer install --no-interaction --prefer-dist --no-scripts

# Copy application files
COPY . .

# Copy and setup entrypoint script
RUN cp /var/www/html/docker/docker-entrypoint.sh /usr/local/bin/ && \
    chmod +x /usr/local/bin/docker-entrypoint.sh

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Expose port 8000
EXPOSE 8000

# Use entrypoint
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]

