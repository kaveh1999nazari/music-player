FROM php:8.3-cli

RUN apt-get update -y && apt-get install -y \
    openssl \
        zip \
        unzip \
        git \
        libonig-dev \
        libzip-dev \
        libpq-dev \
        libicu-dev \
        && docker-php-ext-install intl zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get install -y supervisor
RUN apt-get update && apt-get install -y cron
RUN apt-get update && apt-get install -y nano

# install ffmpeg
RUN apt-get update && apt install ffmpeg -y
# Add this to .env after run Docker :
# FFMPEG_PATH=/usr/bin/ffmpeg
# FFPROBE_PATH=/usr/bin/ffprobe


ENV COMPOSER_ALLOW_SUPERUSER=1

RUN docker-php-ext-install pdo_pgsql pgsql mbstring

WORKDIR /app

COPY . /app

RUN composer install

COPY /docker/bootstrap/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

RUN echo "upload_max_filesize=100M" >> /usr/local/etc/php/php.ini
RUN echo "post_max_size=100M" >> /usr/local/etc/php/php.ini

ENTRYPOINT ["/entrypoint.sh"]

#CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8084"]
CMD ["supervisord", "-c", "/app/docker/supervisor/supervisord.conf"]

EXPOSE 8084

