#!/bin/bash

docker start mysql
cd project
cp .env.example .env
sed -i s'/DB_PORT=3306/DB_PORT=6603/g' .env
php artisan key:generate
php artisan migrate:fresh
php artisan db:seed
mysqldump -h127.0.0.1 -u root --password=root123 -P 6603 test > tests_codeception/_data/dump.sql

cd ..

