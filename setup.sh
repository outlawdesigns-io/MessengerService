#!/bin/bash

a2enmod rewrite
sed -i '/ErrorLog\s\${APACHE_LOG_DIR}\/error\.log/a CustomLog /mnt/LOE/log/messenger.access.log combined' /etc/apache2/apache2.conf
sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf
service apache2 restart
mv /var/www/html/htaccess /var/www/html/.htaccess
mv /var/www/html/email /var/www/config/.email
