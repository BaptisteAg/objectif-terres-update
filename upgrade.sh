#!/bin/bash

php artisan down &&
git pull &&
composer install --no-dev &&
npm run production &&
php artisan app:update &&
php artisan up