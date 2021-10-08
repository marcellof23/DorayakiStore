FROM php:8.0-apache

RUN apt-get update && apt-get upgrade -y

# RUN apt-get install php7.4-sqlite

RUN a2enmod rewrite && service apache2 restart

COPY src/ /var/www/html/

EXPOSE 80
