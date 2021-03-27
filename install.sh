#!/usr/bin/env bash

echo "running install.sh"
cd /var/www/html || exit
composer install --ignore-platform-reqs
[ ! -f /var/www/html/conf/conf.php ] && cp /var/www/html/conf/conf.dist.php /var/www/html/conf/conf.php
[ ! -f /var/www/html/.env ] && cp /var/www/html/.env.dist /var/www/html/.env
apache2-foreground