# start from existing image in online registry
FROM oberd/php-7.4-apache

# install necessary PHP extensions (found inside composer.json)
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install ctype
RUN docker-php-ext-install json

# get composer
RUN curl -sS https://getcomposer.org/installer | php -- \ --install-dir=/usr/bin --filename=composer

# enable laravel
RUN a2ensite laravel

# change working directory
WORKDIR /var/www/app

# copy app contents with a change of ownership other than root,
# www-data is both user and group, host path '.' (current), container path '/var/www/app'
# placing the app inside the standard path '/var/www/' will make it easier for apache to automatically target index.php
COPY --chown=www-data:www-data . /var/www/app
COPY --chown=www-data:www-data ./Public/ /var/www/app/public

# install composer
RUN composer install

# recursively change owner and group for all files in current dirrectory and its subdirectories
RUN chown -R www-data:www-data .
