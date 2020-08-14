#!/bin/sh

# Execute migrations
#php /opt/app/bin/console doctrine:migrations:migrate -n

# Execute fixtures
#php /opt/app/bin/console doctrine:fixtures:load -n

exec php-fpm -F