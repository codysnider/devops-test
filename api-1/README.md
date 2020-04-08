## Getting started

- run `composer install` in this folder
- set up a mysql database with a schema called `my_db`
- alter the file config/database.php with the database credentials, host, and port
- run `php artisan migrate` to make your database tables
- run `php artisan db:seed` to get some good widgets
- alter the file config/app.php and change the `backend_server` to your api-2 project
