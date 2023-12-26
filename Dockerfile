# Use the official PHP image with the desired version
FROM php:8.1.2

# Set the working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    php-curl \
    php-mbstring \
    php-xml \
    php-bcmath \
    php-mysql \
    php-zip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \ 
    cron

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy composer files and install dependencies   --no-scripts --no-autoloader
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

# Copy the rest of the application code
COPY . .

# Copy the .env.example file and create the actual .env file
COPY .env.example .env

# Generate the application key
RUN php artisan key:generate
RUN php artisan storage:link

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Run the scheduled job
# RUN echo "* * * * * php /var/www/html/artisan schedule:run >> /dev/null 2>&1" >> /etc/crontab

# Expose port 80 for web server
EXPOSE 80

# Start the web server
# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
CMD ["/bin/bash", "-c", "php artisan schedule:work > /dev/null 2>&1 & php artisan serve --host=0.0.0.0 --port=80"]

