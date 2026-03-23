FROM php:8.2-apache

RUN docker-php-ext-install mysqli

COPY ./pagina_php/ /var/www/html/

EXPOSE 80