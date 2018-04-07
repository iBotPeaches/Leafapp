#!/usr/bin/env bash
cp .env.example .env
yarn install
mysql --user=connor_testing --password=$DB_PASSWORD -BNe "show tables" connor_testing | tr '\n' ',' | sed -e 's/,$//' | awk '{print "SET FOREIGN_KEY_CHECKS = 0;DROP TABLE IF EXISTS " $1 ";SET FOREIGN_KEY_CHECKS = 1;"}' | mysql --user=connor_testing --password=$DB_PASSWORD connor_testing;
./artisan key:generate;
./artisan migrate --env=testing;
./artisan db:seed --env=testing;
gulp
./vendor/bin/phpunit;