FROM php:8.0-apache

RUN apt-get update && apt-get upgrade -y

RUN apt-get  install -y sqlite3 libsqlite3-dev

RUN a2enmod rewrite && service apache2 restart

COPY src/ /var/www/html/

RUN chmod -R 777 config

RUN chown -R :www-data /var/www/html/config/db

EXPOSE 80

# CMD ["php", "-S", "localhost:5000"