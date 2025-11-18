FROM php:8.2-apache

# MySQL extensions install karo
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Apache ka working folder
WORKDIR /var/www/html

# Saari project files copy karo
COPY . /var/www/html

# Agar .htaccess / routing use karte ho
RUN a2enmod rewrite

EXPOSE 80