#!/bin/bash

php artisan down &&
git pull &&
composer install
php artisan app:update &&
npm run production && 
php artisan up
