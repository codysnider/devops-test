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
