FROM ghcr.io/linuxserver/baseimage-alpine:3.17
LABEL Maintainer="CauseFX <causefx@me.com>"
LABEL Description="Lightweight container with Nginx 1.24 & PHP 8.1 based on Alpine Linux."

# Setup document root
WORKDIR /var/www/html

# Install packages and remove default server definition
RUN apk add --no-cache \
  curl \
  git \
  nginx \
  npm \
  php82 \
  php82-bcmath \
  php82-ctype \
  php82-curl \
  php82-dom \
  php82-fileinfo \
  php82-fpm \
  php82-gd \
  php82-iconv \
  php82-intl \
  php82-json \
  php82-ldap \
  php82-mbstring \
  php82-mysqli \
  php82-opcache \
  php82-openssl \
  php82-pcntl \
  php82-pdo \
  php82-pdo_mysql \
  php82-pdo_sqlite \
  php82-phar \
  php82-session \
  php82-simplexml \
  php82-sqlite3 \
  php82-tokenizer  \
  php82-xml \
  php82-xmlreader \
  php82-xmlwriter \
  php82-zip \
  php82-zlib \
  supervisor 

RUN mkdir /home/npm
RUN mkdir /home/composer

ENV COMPOSER_HOME /home/composer

RUN npm -g config set cache /home/npm

# Configure nginx - http
COPY config/nginx.conf /etc/nginx/nginx.conf

# Configure nginx - default server
COPY config/conf.d /etc/nginx/conf.d/

# Configure PHP-FPM
COPY config/fpm-pool.conf /etc/php82/php-fpm.d/www.conf
COPY config/php.ini /etc/php82/conf.d/custom.ini

# Configure supervisord
COPY config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Install composer from the official image
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Link PHP 8.2 to PHP
RUN ln /usr/bin/php82 /usr/bin/php

# Install Laravel
RUN composer global require laravel/installer --optimize-autoloader --no-interaction --no-progress
RUN composer global require symfony/var-dumper --optimize-autoloader --no-interaction --no-progress

# Make sure files/folders needed by the processes are accessable when they run under the nobody user
#RUN chown -R nobody.nobody /var/www/html /run /var/lib/nginx /var/log/nginx /home/npm /home/composer

# Switch to use a non-root user from here on
#USER nobody

# Add application
#COPY --chown=nobody src/ /var/www/html/

# Expose the port nginx is reachable on
EXPOSE 8080-8081

# Let supervisord start nginx & php-fpm
#CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping

COPY /root /
CMD sh /etc/cont-init.d/30-install

# Add Composer vendor to path
ENV PATH="$PATH:/home/composer/vendor/bin"


