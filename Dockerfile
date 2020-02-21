FROM php:7.4-apache

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Override with custom opcache settings
#COPY config/opcache.ini $PHP_INI_DIR/conf.d/

COPY . /var/www/html/
