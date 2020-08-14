## About
Laravel Admin Panel

## Requirements
- PHP >= 7.2.5
- Laravel >= 7.0
- MySql >= 5.6

## Installation 
Clone project through this github URL.
- git clone https://github.com/mbbhatti/adminpanel.git

Laravel utilizes composer to manage its dependencies. So, before using Laravel, make sure you have composer installed on your machine. To download all required packages run this command.
- composer install

Vue js utilizes npm to manage its dependencies. So, before using it, make sure you have npm installed on your machine. To get all required packages run this command.
- npm install

This command will help to make storage available
- php artisan storage:link

## Database Setup
You need to create a .env file from. env.example. For this run this command if .env not exists.
-  cp .env.example .env

Then, run this command to create key in .env file if not exists.
- php artisan key:generate

Now, set your database credential against these in .env file.

- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=homestead
- DB_USERNAME=homestead
- DB_PASSWORD=secret

Use this command to create database tables and fake entries.
- php artisan migrate:refresh --seed

## Test
Use this command for single file
- vendor/bin/phpunit --filter [FileName]

Use this command for all files tests
- vendor/bin/phpunit

## Run project
Use this command on run project without docker
- php artisan serve --port=8080
