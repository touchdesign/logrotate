FROM php:7.4-alpine

LABEL maintainer="Christin Gruber <c.gruber@touchdesign.de>"
LABEL description="PHP 7.4 docker image"

RUN apk add ncurses \
    && apk add gnupg \
    && apk add bash

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions zip

COPY --from=composer /usr/bin/composer /usr/local/bin/
ENV COMPOSER_ALLOW_SUPERUSER 1

COPY --from=christingruber/phive /usr/local/bin/phive /usr/local/bin/

WORKDIR /box

ENTRYPOINT ["php"]