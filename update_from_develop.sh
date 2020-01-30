#!/bin/bash
git pull origin develop && npm update && composer update && php artisan migrate && php artisan cache:clear
