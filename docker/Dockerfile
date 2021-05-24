FROM php:7.2-apache-stretch

RUN apt-get update
RUN apt-get upgrade -y

RUN apt-get install -y --no-install-recommends \
    zip \
    unzip \
    zlib1g-dev libpng-dev vim


RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php --version=1.10.22
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
RUN composer -v

RUN a2enmod rewrite
COPY apache/vhost.conf /etc/apache2/sites-available/000-default.conf


# Add the application
#COPY . /var/www/html/vienais
WORKDIR /app

#RUN pwd .
#RUN ls -l /var/www/html/vienais/docker/apache/

CMD ["/app/docker/start.sh"]