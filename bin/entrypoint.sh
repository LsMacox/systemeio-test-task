#!/bin/bash

set -e

rm -rf /var/www/var/cache

php /var/www/bin/console cache:warmup

docker-php-entrypoint php-fpm

exec "$@"