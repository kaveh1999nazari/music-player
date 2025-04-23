#!/bin/bash

CRON_JOB="* * * * * cd /app && /usr/local/bin/php artisan schedule:run >> /app/storage/logs/schedule-debug.log 2>&1"
(crontab -l 2>/dev/null; echo "$CRON_JOB") | crontab -

# Start cron
service cron start

# run with supervisord
exec "$@"



