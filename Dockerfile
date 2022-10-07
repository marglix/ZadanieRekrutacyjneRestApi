FROM php:7.4-fpm

RUN apt-get update \
    && apt-get install -y git zip libpq-dev libicu-dev \
    && docker-php-ext-install pgsql pdo pdo_pgsql intl \
    && docker-php-ext-enable opcache
RUN curl -sS 'https://getcomposer.org/installer' | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash \
    && apt-get install symfony-cli

WORKDIR /app
COPY . /app

RUN composer install --no-interaction --no-dev
RUN php bin/console lexik:jwt:generate-keypair
RUN symfony server:ca:install

EXPOSE 8000
CMD php bin/console doctrine:migrations:migrate && symfony serve