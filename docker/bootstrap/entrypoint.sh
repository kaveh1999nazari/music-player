#!/bin/bash

CRON_JOB="* * * * * cd /music && /usr/local/bin/php artisan schedule:run >> /music/storage/logs/schedule-debug.log 2>&1"
(crontab -l 2>/dev/null; echo "$CRON_JOB") | crontab -

# Start cron
service cron start

# Run migrations automatically
cd /music

if [ ! -d "vendor" ]; then
    composer install
fi

php artisan migrate --force

# run with supervisord
exec "$@"
