FROM php:7.3-apache

WORKDIR /app

RUN apt update && apt install -y wget git && \
wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet && \
mv composer.phar /usr/local/bin/composer && chmod +x /usr/local/bin/composer && \
rm -rf /var/lib/apt/lists/* 