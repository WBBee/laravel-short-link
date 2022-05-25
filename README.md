# laravel-shorten-link
Simple Laravel shorten link with simple admin panel,

## What's this repo about

Simply, it's a basic create, read, update and delete operation to create shorten link with Laravel 9.0. 

## Preview
![PANEL](https://res.cloudinary.com/kingsconsult/image/upload/v1602364575/crud_llekuf.png)

## Requirements 

- PHP >= 8.*.*
- Laravel = 9.*.*
- Bootstrap
- Reference = http://bit.ly/

## Installation

1. clone this repo
2. change directory to this project
3. run composer install
4. run cp .env.example .env
    * dont forget to modify the .env file
5. run php artisan key:generate
6. run php artisan migrate --seed
    * Login:
        email: email@admin.com
        pass: admin123
7. php artisan serve

Now you can create your own short links. 
<br>


