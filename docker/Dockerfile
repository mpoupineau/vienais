FROM php:7.2-apache-stretch

RUN apt-get update
RUN apt-get upgrade -y

RUN apt-get install -y --no-install-recommends \
    zip \
    unzip \
    zlib1g-dev

# useless in prod env
RUN apt-get install -y --no-install-recommends \
    vim

RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo pdo_mysql


RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php --install-dir=/usr/local/bin
RUN ln -s /usr/local/bin/composer.phar /usr/local/bin/composer
RUN php -r "unlink('composer-setup.php');"

RUN a2enmod rewrite
COPY apache/vhost.conf /etc/apache2/sites-available/000-default.conf


# Add the application
#COPY . /var/www/html/vienais
WORKDIR /app

#RUN pwd .
#RUN ls -l /var/www/html/vienais/docker/apache/

CMD ["/app/docker/start.sh"]