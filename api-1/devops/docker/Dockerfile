FROM php:7.1-fpm

# Install system dependencies to run Laravl
RUN apt-get update && \
    apt-get install -y --force-yes --no-install-recommends \
    	build-essential \
    	libpng-dev \
    	libjpeg62-turbo-dev \
    	libfreetype6-dev \
    	locales \
        libmemcached-dev \
        zip \
	    jpegoptim optipng pngquant gifsicle \
	    unzip \
        curl \
        wait-for-it

RUN apt-get autoclean -y && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www
USER www

WORKDIR /var/www
    
EXPOSE 9000

CMD ["php-fpm"]