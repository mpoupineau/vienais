#!/bin/sh
set -e

if [ "$SYMFONY_ENV" = 'prod' ]; then
    echo 'Environment is prod'
    composer install --prefer-dist --no-dev --no-progress --no-suggest --optimize-autoloader --classmap-authoritative
else
    echo "Environment is not prod ($SYMFONY_ENV)"
    composer install --prefer-dist --no-progress --no-suggest
fi

# Start Apache with the right permissions after removing pre-existing PID file
rm -f /var/run/apache2/apache2.pid

exec /app/docker/apache/start_safe_perms -DFOREGROUND