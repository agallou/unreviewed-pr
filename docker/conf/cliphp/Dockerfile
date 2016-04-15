FROM php:5.5
RUN apt-get update --fix-missing
RUN apt-get install -y zlibc zlib1g zlib1g-dev
RUN echo "date.timezone=Europe/Paris" >> "/usr/local/etc/php/php.ini"
RUN apt-get update --fix-missing
RUN apt-get install -y libpq-dev
RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install mbstring

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pgsql
RUN docker-php-ext-install zip

