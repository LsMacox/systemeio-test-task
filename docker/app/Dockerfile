FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nano \
    wget

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV PATH="$PATH:/var/www/bin:/var/www/vendor/bin"

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl opcache && \
    docker-php-ext-enable opcache

RUN apt-get update && apt-get install -y supervisor && rm -rf /var/lib/apt/lists/*

RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv $HOME/.symfony5/bin/symfony /usr/local/bin/symfony

ADD docker/app/php.ini /usr/local/etc/php/php.ini
ADD docker/app/php-cli.ini /usr/local/etc/php/php-cli.ini
ADD docker/app/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN useradd -ms /bin/bash lsmacox

COPY . /var/www

RUN chown lsmacox /var/www/

USER lsmacox

WORKDIR /var/www

RUN composer install --prefer-dist --no-scripts
RUN php bin/console assets:install --no-interaction

CMD ["/bin/bash", "/var/www/bin/entrypoint.sh"]
