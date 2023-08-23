#!/bin/bash

php artisan down &&
git pull &&
composer install
php artisan app:update &&
php artisan up
