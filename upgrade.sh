#!/bin/bash

php artisan down &&
git pull origin develop &&
composer install --no-dev &&
npm install &&
npm run production &&
php artisan app:update &&
php artisan up
