FROM php:8.2-apache

# Install required PHP extensions and enable Apache modules
RUN docker-php-ext-install mysqli && \
    a2enmod rewrite

# Copy your application
COPY ./ /var/www/html
RUN chmod -R 0755 /var/www/html

# Remove git artifacts
RUN rm -rf /var/www/html/.git /var/www/html/.gitmodules

# Allow .htaccess overrides
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Move htaccess if needed
RUN if [ -f /var/www/html/htaccess ]; then mv /var/www/html/htaccess /var/www/html/.htaccess; fi

# Use production ini
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

EXPOSE 80
CMD ["apache2-foreground"]
