# Use official PHP-Apache image
FROM php:8.0-apache

# Install PHP extensions (GD for image handling, mysqli for MySQL)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory inside container
WORKDIR /var/www/html

# Copy all project files to the container
COPY . .

# Change Apache's DocumentRoot to the public directory
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Add <Directory> directive for public directory in Apache config
RUN echo '<Directory /var/www/html/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

# Expose default Apache port
EXPOSE 80

# Start Apache server in the foreground
CMD ["apache2-foreground"]
