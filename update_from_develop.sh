#!/bin/bash
git pull origin develop \
&& npm install \
&& composer install \
&& php artisan migrate:fresh \
&& php artisan db:seed \
&& npm run dev \
&& php artisan view:clear \
&& php artisan cache:clear 
