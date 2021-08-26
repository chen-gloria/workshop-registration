FROM php:7.4-apache

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/workshop-registration

RUN apt-get update \
    && apt-get dist-upgrade -y \
    && apt-get autoremove -y \
    && apt-get install libonig-dev libssl-dev unzip wait-for-it -y

RUN docker-php-ext-install bcmath pdo_mysql \
    && mkdir -p /var/www/workshop-registration

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY . /var/www/workshop-registration

RUN chmod 755 /var/www/workshop-registration/docker/run.sh \
    && composer install --working-dir=/var/www/workshop-registration

COPY docker/apache2-workshop-registration.conf /etc/apache2/conf-available/workshop-registration.conf

RUN \
    a2enconf workshop-registration && \
    a2enmod rewrite && \
    chown -R www-data:www-data /var/www/workshop-registration/ && \
    chmod u+w,g+w -R /var/www/workshop-registration/

EXPOSE 8070

CMD "/var/www/workshop-registration/docker/run.sh"