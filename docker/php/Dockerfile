FROM php:8.3.9-fpm

# install package
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql pdo_pgsql bcmath \
    && docker-php-ext-install mysqli \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# setup Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# setup working directory
WORKDIR /var/www

# copy code to folder /var/www
COPY ../. /var/www

# setup package laravel
RUN composer install --prefer-dist --no-scripts --no-dev --optimize-autoloader || true

# change mode to folder
RUN chown -R www-data:www-data /var/www \
    && chown -R www-data:www-data /var/www/storage \
    && chown -R www-data:www-data /var/www/bootstrap/cache \
    && chmod -R 777 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage/logs

# define port php listen
EXPOSE 9000

# running php-fpm
CMD ["php-fpm"]
