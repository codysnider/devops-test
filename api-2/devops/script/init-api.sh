#!/bin/bash

if [ ! -f "/var/www/.env" ]
then
	cp devops/config/api/.env.local .env
fi

if [ ! -d "/var/www/vendor" ]
then
	composer install
	php artisan key:generate
fi

