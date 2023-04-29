requirments

Php version 8.1
Laravel Version 10.8
mysql
composer

steps for installation


1. go to the root directory and run command composer:install.
2. copy .env.example and rename copied file to .env 
3. change APP_NAME variable value whatever you want in .env file.
4. change database credenials .env file.
5. run command php artisan migrate to run migration file.
6. run command php artisan db:seed to seed data into database.
7. run command php artisan:serve to start project.

visit below urls to check functionalities.

http://127.0.0.1:8000/blogger/register
http://127.0.0.1:8000/admin/register
http://127.0.0.1:8000/login

