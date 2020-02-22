FROM php:7.4-apache

RUN docker-php-ext-install opcache pdo_mysql

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Override with custom opcache settings
COPY docker/opcache.ini $PHP_INI_DIR/conf.d/

COPY . /var/www/html/

RUN ln -s /var/www/html/docker/laravel-entrypoint /usr/local/bin/

ENTRYPOINT ["laravel-entrypoint"]
