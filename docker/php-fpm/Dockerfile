FROM php:7.4-fpm-alpine as production

# Install needed modules to run the application
RUN apk update \
 && apk --quiet add \
    libzip-dev \
    icu-dev

# Add php extension to work with zip files
RUN docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    zip \
    bcmath \
    intl

WORKDIR /opt/app

# Copy source code into container
COPY ./src/ .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install production dependencies
RUN composer install --no-dev

FROM production as development

# Install with dev dependencies
CMD sh -c "composer install && docker-php-entrypoint php-fpm -F"
COPY ./docker/php-fpm/rootfs /

# xDebug
ARG XDEBUG_VERSION=2.9.3
RUN apk add autoconf g++ make
RUN pecl install xdebug-${XDEBUG_VERSION}; \
    docker-php-ext-enable xdebug;

RUN echo "xdebug.remote_host=docker.for.mac.localhost" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Mysql and dependencies
RUN apk add libxml2-dev
RUN docker-php-ext-install mysqli pdo pdo_mysql xml
COPY ./docker/php-fpm/init.sh /usr/local/bin/init.sh
COPY ./docker/php-fpm/wait-for-it.sh /usr/local/bin/wait-for-it.sh
