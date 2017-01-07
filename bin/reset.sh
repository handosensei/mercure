#!/usr/bin/env bash

if [ "$#" != 1 ];then
    echo "Usage: reinit.sh env";
    exit;
fi

php bin/console cache:clear --env=$1
php bin/console doctrine:database:drop --force --env=$1
php bin/console doctrine:database:create --env=$1
php bin/console doctrine:schema:update --force --env=$1
php bin/console doctrine:fixtures:load --purge-with-truncate -n --env=$1
