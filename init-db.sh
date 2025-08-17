#!/bin/bash
# Wait for MySQL to be ready
until mysql --ssl-mode=DISABLED -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASSWORD" -e "SELECT 1" > /dev/null 2>&1; do
  echo "Waiting for database connection..."
  sleep 2
done

php /var/www/html/db_config.php