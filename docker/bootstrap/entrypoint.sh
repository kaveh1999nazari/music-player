#!/bin/bash

CRON_JOB="* * * * * cd /music && /usr/local/bin/php artisan schedule:run >> /music/storage/logs/schedule-debug.log 2>&1"
(crontab -l 2>/dev/null; echo "$CRON_JOB") | crontab -

# Start cron
service cron start

# Run migrations automatically
cd /music

echo "📦 Checking for vendor directory..."

if [ ! -d "vendor" ]; then
    echo "📦 vendor not found. Running composer install..."
    composer install
else
    echo "✅ vendor directory found, skipping composer install."
fi

# Run meili setup once
php artisan meili:setup
echo "✅ MeiliSearch typo tolerance setup done."

php artisan migrate --force
echo "✅ migration created successfully."

php artisan storage:link
echo "✅ setting local storage."

# run with supervisord
exec "$@"
