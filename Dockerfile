FROM php:8.3-alpine

RUN apk add --no-cache \
    bash \
    curl \
    git \
    unzip \
    postgresql-dev \
    libxml2-dev \
    oniguruma-dev \
    icu-dev \
    zlib-dev \
  && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    xml \
    intl \
  && rm -rf /var/cache/apk/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
