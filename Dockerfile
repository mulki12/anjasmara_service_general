FROM php:7.4-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev zip unzip git libonig-dev librabbitmq-dev libssh-dev \
    && pecl install mcrypt-1.0.4 \
    && docker-php-ext-enable mcrypt\
    && pecl install http://pecl.php.net/get/amqp-1.10.2.tgz \
#    && rm -rf /tmp/pear \
    && docker-php-ext-enable amqp 

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo mbstring pdo_mysql
RUN docker-php-ext-install sockets

WORKDIR /generals
COPY . /generals

RUN composer install
CMD php artisan queue:work
CMD php artisan key:generate
CMD php artisan migrate:fresh
CMD php artisan serve --host=0.0.0.0 --port=3001
RUN chmod -R 777 storage

EXPOSE 3001


