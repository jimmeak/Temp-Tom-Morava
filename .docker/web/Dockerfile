FROM php:8.3-apache

# ===== Setting the System =====
RUN	    apt-get update  \
        && apt-get install --yes --no-install-recommends \
            vim wget bzip2 curl git unzip libzip-dev zip libpq-dev libonig-dev libicu-dev \
            libfreetype6-dev libjpeg62-turbo-dev libpng-dev

RUN	    mkdir /var/www/logs

# ===== Composer Installation =====
RUN	    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# ===== Installation of PHP Extensions =====
RUN	    docker-php-ext-install pdo
RUN	    docker-php-ext-install pdo_pgsql
RUN	    docker-php-ext-install pgsql
RUN	    docker-php-ext-install intl
RUN	    docker-php-ext-install mbstring
RUN	    docker-php-ext-install zip
RUN	    docker-php-ext-install gd
RUN	    docker-php-ext-install opcache

# ===== XDEBUG =====
RUN	    pecl install xdebug
RUN	    docker-php-ext-enable xdebug


# ===== REDIS =====
RUN	    pecl install -o -f redis
RUN	    docker-php-ext-enable redis


# ===== Work Settings =====
WORKDIR /var/www/html
EXPOSE  80 443
