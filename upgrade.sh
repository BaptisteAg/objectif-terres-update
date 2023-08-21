#!/bin/bash

php artisan down &&
git pull &&
composer install
php artisan app:update &&
export NODE_OPTIONS=--openssl-legacy-provider && npm run production &&
php artisan up
