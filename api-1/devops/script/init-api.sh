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

VAR1="Nothing to migrate."
VAR2=$(php artisan migrate --pretend --force)
if [ ! "$VAR1" = "$VAR2" ]
then
	php artisan migrate --force
	php artisan db:seed --force
fi