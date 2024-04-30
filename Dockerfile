FROM php:8.2-apache
ENV TZ=America/Chicago
RUN docker-php-ext-install mysqli
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
ADD ./ /var/www/html
RUN chmod -R 0755 /var/www/html
RUN chmod +x /var/www/html/Libs/ContainerSetup/webContainerSetup.sh
RUN /var/www/html/Libs/ContainerSetup/webContainerSetup.sh /mnt/LOE/log/messenger.access.log
RUN mkdir /var/www/config
RUN mv /var/www/html/email /var/www/config/.email
EXPOSE 443
