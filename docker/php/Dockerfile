# Указываем базовый образ PHP с поддержкой FPM
FROM php:8.1-fpm as php

WORKDIR /var/www/html

# Устанавливаем необходимые системные зависимости
RUN apt-get update && apt-get install -y \
    build-essential \
    locales \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    nano\
    supervisor\
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql bcmath

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN mkdir -p "/etc/supervisor/logs"
# Скопируйте конфигурации
COPY ./docker/php/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN pecl install -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

# Устанавливаем Node.js и npm (опционально, если понадобится для фронтенда)
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Устанавливаем рабочую директорию
COPY . /var/www/html

# Настройка прав доступа
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY --chown=www:www . /var/www/html

# Change current user to www
USER www

# Открываем порт 9000 для php-fpm
# EXPOSE 9000

# Запускаем PHP-FPM сервер
# CMD ["php-fpm"]

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# ENTRYPOINT [ "docker/entrypoint.sh" ]
