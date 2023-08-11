#!/bin/bash

php artisan down &&
git pull origin develop &&
composer install
php artisan app:update &&
npm run production && 
php artisan up
