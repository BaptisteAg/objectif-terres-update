#!/bin/bash

php artisan down &&
git pull &&
composer install &&
npm ci &&
npm run production &&
php artisan app:update &&
php artisan up
