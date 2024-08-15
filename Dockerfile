# Use the official PHP image as the base image
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions http gd imap pdo_mysql mbstring mysqli exif pcntl bcmath zip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN install-php-extensions @composer

# Copy existing application directory contents
COPY . /var/www

RUN composer update && composer install

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
