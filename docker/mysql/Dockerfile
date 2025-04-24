FROM docker.io/library/mysql:8.0

COPY ./docker/mysql/config /etc/mysql/conf.d
COPY ./docker/mysql/rootfs/docker-entrypoint-initdb.d /docker-entrypoint-initdb.d
