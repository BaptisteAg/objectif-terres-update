#!/bin/bash

php artisan down &&
git pull &&
composer install &&
npm ci &&
php artisan app:update &&
php artisan l5-swagger:generate &&
php artisan up
