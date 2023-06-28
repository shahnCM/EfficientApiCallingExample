FROM php:8.2.0-apache

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install apt-utils
RUN apt-get update && apt-get install apt-utils

# Install system dependencies
RUN apt-get install -y \
    git \
    zip  \
    curl  \
    unzip  \
    g++   \
    gcc    \
    openssl \
    libzip-dev\
    libssh-dev \
    libjpeg-dev \
    libssl-dev\
    libbz2-dev \
    libxml2-dev \
    libpng-dev \
    libonig-dev \
    libmcrypt-dev \
    librabbitmq-dev\
    libreadline-dev \
    libfreetype6-dev \
    curl        \
    libicu-dev   \
    libpcre3-dev  \
    build-essential\
    libcurl4-openssl-dev


# Point to Public Dir for Laravel App
#ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
#RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
#RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf


# MOD REWRITE
RUN a2enmod rewrite headers


# Fetching Extensions Manually
# Get Redis And Put it in a Dir For Direct Install
RUN mkdir -p /usr/src/php/ext/redis
RUN	curl -fsSL https://pecl.php.net/get/redis --ipv4 | tar xvz -C "/usr/src/php/ext/redis" --strip 1
# Get MongoDb And Put it in a Dir For Direct Install
RUN mkdir -p /usr/src/php/ext/mongodb
RUN	curl -fsSL https://pecl.php.net/get/mongodb --ipv4 | tar xvz -C "/usr/src/php/ext/mongodb" --strip 1
# Get Amqp And Put it in a Dir For Direct Install
RUN mkdir -p /usr/src/php/ext/amqp
RUN	curl -fsSL https://pecl.php.net/get/amqp --ipv4 | tar xvz -C "/usr/src/php/ext/amqp" --strip 1
# Get OpenSwoole And Put it in a Dir For Direct Install
RUN mkdir -p /usr/src/php/ext/openswoole
RUN	curl -fsSL https://pecl.php.net/get/openswoole --ipv4 | tar xvz -C "/usr/src/php/ext/openswoole" --strip 1

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*


# Install PHP extensions **(Redis, Mongo, Amqp will only work for PHP 8 within this block)
RUN docker-php-ext-install \
    gd \
    bz2 \
    intl \
    redis \
    zip\
    amqp\
    exif \
    iconv \
    mongodb\
    pcntl  \
    opcache \
    calendar \
    xml   \
    bcmath \
    mbstring\
    pdo_mysql\
    sockets \
    openswoole

# Install openswoole through pecl with configuration
# RUN pecl install -D 'enable-sockets="yes" enable-openssl="yes" enable-http2="yes" enable-mysqlnd="yes" enable-swoole-json="yes" enable-swoole-curl="yes" enable-cares="yes" with-postgres="yes"' openswoole

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Pull NodeJs From REPO
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash
# Install NodeJs
RUN apt-get install nodejs
RUN npm install -g yarn --save

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www/html

# Copy Everything from local to docker-volume
COPY ./ /var/www/html

# Set User
USER $user

# Expose Port for Forwarding
# EXPOSE 80
