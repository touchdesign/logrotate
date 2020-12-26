FROM php:8.0-alpine

LABEL maintainer="Christin Gruber <c.gruber@touchdesign.de>"
LABEL description="PHP 8.0 docker image"

RUN apk add ncurses \
    && apk add gnupg \
    && apk add bash

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions zip

COPY --from=composer /usr/bin/composer /usr/local/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /box

ENTRYPOINT ["php"]