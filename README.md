## Welcome to the Health Recovery Solutions Widgets API

 
This is a devops interview project. The goal of this assignment is to test for creativity in solving a common problem. There are no right answers. We are more interested in the approach.

You have been given 2 codebases. These codebases are in different
repositories represented here as folders `api-1` and `api-2`


### The Goals

#### Goal #1

You must containerize these two applications to be shippable to production
as separate docker images. You may consider using a php-fpm-nginx docker image such as https://hub.docker.com/r/richarvey/nginx-php-fpm/ or roll your own docker image.
This application does very little and does not require any special php modules.


#### Goal #2

Developers must be able to work on both projects locally. This means that one developer
can alter both projects simultaneously. Even though the project files are in one place here, pretend that each project is a separate repository that must be checked out independently.
`api-1` must be able to communicate with `api-2`

### Project breakdown

- Both projects are written in PHP using the Laravel framework. You do not need to be familar with the framework. Each project has instructions on how to build the code.
- Project `api-1` is the public api project. On production it will be served under a domain name such as `https://api.hrstech.com/`
Please ensure that when this container goes live we will be able to serve it with `https`. For this demonstration it does not need to be a real certificate authority. A self signed certificate will be sufficient.

- This project is a laravel project and requires a mysql 5.7 database. The developer has provided a README file inside the project folder to get started.

- Project `api-2` is a PRIVATE api. It is not to be exposed to the outside world under any circumstances. The only consumer of this api will be `api-1`. The url for this api can be a private dns entry.


#### Goal Acceptance

- Use your best judgement to set up a development environment that makes it as easy as possible for developers. (Hint - we like docker and docker-compose)
- You may use nginx to do a reverse proxy locally so the developer can edit code and serve `api-1` locally under a domain such as `https://api.hrstech.local/`
- Using a tool such as postman the developer can test their api locally. It should look similar to the provided image `screenshot1.png`
- Document and discuss which tools are used
- Provide instructions on how to launch this project on production, including any dns setup. You may assume we will have full control of public and private dns zones.

#### Document and discuss which tools are used

## Summary

- [*Instruction*](#instruction)
- [*Maintenance for Dev Ops*](#maintenance-for-dev-ops)
- [*Documentation*](#documentation)

## Instruction

Project requirements: 
- [Docker](https://www.docker.com/get-started)
- [Docker-compose](https://docs.docker.com/compose/install/)


Start the project locally

```
docker-compose up
```

Edit your vhost (example on Ubuntu)

```
sudo nano /etc/hosts
```

Add this line

```
127.0.0.1       api.hrstech.local
```

#### Available website

| Application                | URL                        |
|----------------------------|----------------------------|
| api-1                      | https://api.hrstech.local/ |
| adminer (MySQL web client) | http://127.0.0.1:8080/     |

#### Database

| Field       | Value                     |
|-------------|---------------------------|
| System      | MySQL                     |
| Server/IP   | mysql                     |
| Username    | root                      |
| Password    | averycomplexpasswordornot |
| Database    | my_db                     |

## Maintenance for Dev Ops

#### Build PHP Docker image (api) and push it to hub.docker.com

```
docker login
cd api-1/devops/docker/
docker build -t hrs-laravel-api .
docker tag hrs-laravel-api omarsadek/hrs-laravel-api
docker push omarsadek/hrs-laravel-api
```

#### Generate Self-Signed SSL Certificate

```
sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout api-1/devops/config/nginx/certificate/api.hrstech.local.key -out api-1/devops/config/nginx/certificate/api.hrstech.local.crt
```

## Documentation

I used docker and docker-compose to run this project, automated some tasks, so a developer only needs to run a single command to make it work.

Docker compose breakdown:

- mysql: with a volume to maintain the database data intact after a restart of docker image.

- adminer: a web MySQL cleint.

- api-1: a minimal debian docker image to compile and execute the php code on demand for the nginx server throw php-fpm.
It has also a shared volume, so the developer can edit the code while the docker is up.

- nginx-api-1: a minimal nginx server who listens on port 443 (https with a self signed certificate) and render the php code from api-1 throw the internal docker-compose network on port 9000.

- init-api-1: a minimal debian docker using a personalized user to init api-1 when the MySql database is ready and running (https://github.com/vishnubob/wait-for-it), so it would not have any issue with file permissions.
It will execute the instruction of this script (requirement to make api-1 working): api-1/devops/script/init-api.sh

```
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
```

- api-2: same as api-1 docker image

- nginx-api-2: a minimal nginx server which is grapping the compiled and executed code from api-2 using the docker-compose internal network (private network)

- init-api-2: a minimal debian docker executing the required instruction for api-2: api-2/devops/script/init-api.sh
```
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

```