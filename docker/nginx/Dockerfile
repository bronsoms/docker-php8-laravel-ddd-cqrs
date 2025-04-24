FROM nginx:1.24 as base

COPY ./docker/nginx/rootfs/ /

RUN apt-get update \
 && apt-get install --no-install-recommends -y \
      netcat \
      telnet \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/*

WORKDIR /opt/app/

HEALTHCHECK --timeout=1s --interval=1s --retries=3 \
   CMD echo "GET http://localhost/nginx-healthcheck" | nc localhost 80 | grep -q "OK" || exit 1 \
     echo 'exit' | telnet php-fpm 9000 | grep "Connected to php-fpm"

FROM base AS production

COPY ./src/public /opt/app/public

FROM base AS local