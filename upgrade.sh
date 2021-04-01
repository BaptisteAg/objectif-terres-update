#!/bin/bash

git pull origin develop &&
composer install &&
php artisan down &&
php artisan app:update &&
php artisan up
