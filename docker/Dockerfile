FROM php:7.2-fpm-alpine3.7

LABEL maintainer="Damien JARRY <damien.jarry@salade2chats.com>"

ARG PHALCON_VERSION=3.3.1
ARG PHALCON_EXT_PATH=php7/64bits

# RUN apk add php7-pgsql --no-cache --repository http://nl.alpinelinux.org/alpine/edge/community
# RUN docker-php-ext-install pdo pdo_pgsql
# Install Postgre PDO
RUN apk add --no-cache postgresql-libs postgresql-dev \
    && docker-php-ext-install pdo_pgsql pgsql

RUN set -xe && \
        # Compile Phalcon
        curl -LO https://github.com/phalcon/cphalcon/archive/v${PHALCON_VERSION}.tar.gz && \
        tar xzf ${PWD}/v${PHALCON_VERSION}.tar.gz && \
        docker-php-ext-install -j $(getconf _NPROCESSORS_ONLN) ${PWD}/cphalcon-${PHALCON_VERSION}/build/${PHALCON_EXT_PATH} && \
        # Remove all temp files
        rm -r \
            ${PWD}/v${PHALCON_VERSION}.tar.gz \
            ${PWD}/cphalcon-${PHALCON_VERSION}

COPY docker-phalcon-* /usr/local/bin/
