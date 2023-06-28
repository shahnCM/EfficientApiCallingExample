#!/bin/bash

npm install && npm run build
composer install
php artisan migrate
php artisan test
php artisan queue:work &
php artisan serve --host=0
