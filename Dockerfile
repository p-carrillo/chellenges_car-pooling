FROM php:8-cli

RUN apt-get update && apt-get install -y \
    libmcrypt-dev \
    git \
    unzip \
    sqlite3 \
    libsqlite3-dev

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
RUN apt-get install -y symfony-cli apt-transport-https gnupg2
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo

# SQL lite
RUN mkdir /db
RUN /usr/bin/sqlite3 /db/database.sqlite

WORKDIR /car-pool-challenge
ADD . ./
RUN composer install --no-interaction -o

EXPOSE 8000
EXPOSE 9091

