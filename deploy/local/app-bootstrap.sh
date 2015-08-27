#!/bin/sh

# Need to be root for this.
[ `whoami` = root ] || echo "This script needs to run as root -- please enter root password: "
[ `whoami` = root ] || exec su -c $0 root

set -e

EXTERNAL_CONF_DIR=/vagrant/deploy/external-configuration

cp $EXTERNAL_CONF_DIR/dutils-vhost.conf /etc/apache2/sites-enabled
mv /etc/apache2/sites-enabled/000-default.conf /etc/apache2/sites-enabled/000-default.conf.disabled
service apache2 reload
echo "127.0.0.1    download-utils" >> /etc/hosts

if [ ! -f /usr/bin/composer ]; then
 curl -sS https://getcomposer.org/installer | php
 mv composer.phar /usr/bin/composer
fi

cd /vagrant
composer install

php app/console --no-interaction doctrine:migrations:migrate
php app/console cache:warmup
