FROM php:8.0-apache

# OS
RUN apt-get clean \
    && apt-get update \
    && apt-get install -y git \
    && a2enmod rewrite ssl \
    && apt-get install -y locales \
    && locale-gen en_US.UTF-8 \
    && dpkg-reconfigure --frontend=noninteractive locales \
    && sed -i -e 's/# en_US.UTF-8 UTF-8/en_US.UTF-8 UTF-8/' /etc/locale.gen \
    && dpkg-reconfigure --frontend=noninteractive locales \
    && update-locale LC_ALL=en_US.UTF-8 LANG=en_US.UTF-8
ENV LANG en_US.UTF-8
ENV LC_ALL en_US.UTF-8

# PHP
RUN yes | pecl install xdebug && docker-php-ext-enable xdebug \
    && apt-get install -y libzip-dev zip && docker-php-ext-install zip \
    && apt-get install -y libicu-dev && docker-php-ext-configure intl && docker-php-ext-install intl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Apache
RUN mkdir /etc/apache2/ssl \
    && openssl req \
        -new \
        -newkey rsa:4096 \
        -days 365 \
        -nodes \
        -x509 \
        -subj "/C=/ST=/L=/O=/CN=koddlo-customer-api.local" \
        -keyout /etc/apache2/ssl/apache.key \
        -out /etc/apache2/ssl/apache.crt
RUN echo "ServerName koddlo-customer-api" >> /etc/apache2/apache2.conf
RUN service apache2 restart

# App
WORKDIR /var/www
