FROM php:8-cli

RUN apt-get update -y && apt-get install -y libmcrypt-dev

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
RUN apt-get install -y symfony-cli
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo

WORKDIR /test-ci
ADD . ./
RUN composer install --no-interaction -o

EXPOSE 8000
EXPOSE 9091

