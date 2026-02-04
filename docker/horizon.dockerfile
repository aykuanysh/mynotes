FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    unzip \
    && docker-php-ext-install pdo_sqlite pcntl\
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

CMD sh -c "php artisan horizon:install && php artisan horizon"