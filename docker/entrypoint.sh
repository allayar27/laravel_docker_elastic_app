#!/bin/bash

if [ ! -f "vendor/autoload.php" ] then
    composer install --no-progress --no-interaction
fi

if [ ! -f ".env" ] then
    echo "Creating env file for $APP_ENV"
    cp .env.example .env
else
    echo "env file exists."
fi

php artisan key:generate
php artisan migrate:fresh --seed
npm install
npm run dev
npm run build
