# Use official PHP image
FROM php:8.0-apache

# Install dependencies (e.g., MySQL client, extensions)
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev && docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install gd mysqli

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the application files to the container
COPY . .

# Expose port 80 for Apache
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
