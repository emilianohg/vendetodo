#!/bin/bash

cd /app

if [ ! -d "/app/vendor" ] 
then
    composer install
fi

php artisan serve --host 0.0.0.0
