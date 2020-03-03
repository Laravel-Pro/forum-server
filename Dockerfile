FROM wkan/php-apache:7.4

ENV FORUM_PROJECT_ROOT /var/www/html/forum

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
