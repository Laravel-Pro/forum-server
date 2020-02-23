FROM php:7.4-apache

RUN docker-php-ext-install opcache pdo_mysql

ENV FORUM_PROJECT_ROOT /var/www/html/forum

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# site configure file
COPY ./docker/laravel-pro.conf /etc/apache2/sites-available/

# Override with custom opcache settings
COPY docker/opcache.ini $PHP_INI_DIR/conf.d/

# Copy entrypoint script
COPY docker/laravel-entrypoint /usr/local/bin/

RUN a2dissite 000-default.conf \
    && a2ensite laravel-pro.conf \
    && a2enmod rewrite

WORKDIR $FORUM_PROJECT_ROOT

COPY . $FORUM_PROJECT_ROOT

ENTRYPOINT ["laravel-entrypoint"]
