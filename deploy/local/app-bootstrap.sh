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

set +e
rm -f /opt/software/filebot/cache/*
rm -f /opt/software/filebot/data/*
set -e

ln -s /mediacenter /vagrant/mediacenter

# Reinstall transmission
set +e
/etc/init.d/transmission-daemon stop
update-rc.d -f transmission-daemon remove
apt-get -y remove transmission-daemon
apt-get -y remove transmission-cli
apt-get -y remove transmission-common
rm -rf /etc/transmission-daemon
rm -rf /etc/default/transmission-daemon
rm -rf /var/lib/transmission-daemon
rm -rf /usr/share/transmission/
set -e

chmod +x $EXTERNAL_CONF_DIR/install-transmission.sh
$EXTERNAL_CONF_DIR/install-transmission.sh

php app/console --no-interaction doctrine:migrations:migrate
php app/console cache:warmup

filebot -script fn:osdb.login
chown -R pi:pi /opt/software/filebot/data
