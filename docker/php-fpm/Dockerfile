FROM docker.io/php:8.3-fpm-bookworm AS base

RUN --mount=type=cache,target=/var/cache/apt \
    apt-get update \
 && apt-get install -y \
      default-mysql-client \
      iputils-ping \
      libfcgi0ldbl \
      libfreetype6-dev \
      libicu-dev \
      openssh-client \
      telnet \
      unzip \
      wget \
      libzip-dev \
      zip

RUN docker-php-source extract \
 && docker-php-ext-install -j$(nproc) \
      bcmath \
      intl \
      mysqli \
      opcache \
      pdo_mysql \
      sysvmsg \
      zip \
 && docker-php-source delete

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

COPY ./docker/php-fpm/rootfs/ /

RUN mkdir -p /opt/app \
 && chown -R www-data:www-data /var/www /opt/app

USER www-data:www-data

WORKDIR /opt/app/

VOLUME /opt/data

FROM base AS production-base

COPY --chown=www-data:www-data ./src/ /opt/app

RUN composer install --no-dev --no-interaction --optimize-autoloader \
 && composer clear-cache

USER root:root

RUN apt-get clean \
 && rm -rf /var/lib/apt/lists/* \
 && rm -rf /tmp/pear \
 && rm -rf /opt/app/tests \
 && rm -rf /var/www/.ssh

USER www-data:www-data

FROM production-base AS production

HEALTHCHECK --interval=10s --timeout=3s --start-period=60s \
    CMD \
    env -i \
    SCRIPT_NAME=/ping \
    SCRIPT_FILENAME=/ping \
    REQUEST_METHOD=GET \
    cgi-fcgi -bind -connect 127.0.0.1:9000 | grep -i 'pong' || exit 1

FROM base AS local

COPY --chown=www-data:www-data ./src/ /opt/app

USER root:root

RUN docker-php-source extract \
 && pecl bundle -d /usr/src/php/ext xdebug \
 && docker-php-ext-install -j$(nproc) xdebug \
 && docker-php-source delete

RUN --mount=type=cache,target=/var/cache/apt \
    apt-get install -y \
      apt-utils \
      procps \
      python3 \
      sudo \
      tini \
      vim

RUN cp -vrT /etc/skel /var/www \
 && chown -R www-data:www-data /var/www

USER www-data:www-data

RUN composer install --no-interaction --optimize-autoloader

ENTRYPOINT [ "tini", "-g", "--", "docker-php-entrypoint" ]
CMD ["php-fpm"]
