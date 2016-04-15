FROM php:7-apache
RUN apt-get update --fix-missing
RUN apt-get install -y zlibc zlib1g zlib1g-dev
RUN echo "date.timezone=Europe/Paris" >> "/usr/local/etc/php/php.ini"
RUN apt-get update --fix-missing
RUN apt-get install -y libpq-dev
RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install mbstring
RUN echo "Include sites-enabled/" >> /etc/apache2/apache2.conf

COPY apache.conf /etc/apache2/sites-available/000-default.conf

RUN ln -s /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-enabled/000-default.conf

RUN docker-php-ext-install pgsql
RUN a2enmod rewrite

RUN a2enmod headers
