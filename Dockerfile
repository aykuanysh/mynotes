FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    unzip \
    curl \
    && docker-php-ext-install pdo_sqlite

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-interaction --optimize-autoloader && \
    cp .env.example .env && \
    php artisan key:generate && \
    npm install && \
    npm run build && \
    chmod -R 777 storage bootstrap/cache database

EXPOSE 8000

CMD sh -c "touch database/database.sqlite && php artisan migrate:fresh --force --seed && php artisan serve --host=0.0.0.0 --port=8000"