FROM php:8.1-apache

# Install PDO and MySQLi extensions so PHP can talk to Aiven
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli

# Enable Apache URL Rewriting
RUN a2enmod rewrite

# Copy all the CMS files into the container's public web directory
COPY . /var/www/html/

# Permissions so image uploads from the admin panel don't crash
RUN chown -R www-data:www-data /var/www/html/
RUN chmod -R 775 /var/www/html/uploads/

# Expose port 80 for Render
EXPOSE 80
