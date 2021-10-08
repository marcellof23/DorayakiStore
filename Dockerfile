FROM php:7.4-apache

RUN apt-get update && apt-get upgrade -y

RUN apt-get install sqlite3

RUN a2enmod rewrite 

COPY src/ /var/www/html/

EXPOSE 80
