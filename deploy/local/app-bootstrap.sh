#!/bin/sh

# Need to be root for this.
[ `whoami` = root ] || echo "This script needs to run as root -- please enter root password: "
[ `whoami` = root ] || exec su -c $0 root

set -e
SERVICES_USER=pi
DOMAIN_NAME='download-utils'
EXTERNAL_CONF_DIR=/vagrant/deploy/external-configuration

cp $EXTERNAL_CONF_DIR/dutils-vhost.conf /etc/apache2/sites-enabled
mv /etc/apache2/sites-enabled/000-default.conf /etc/apache2/sites-enabled/000-default.conf.disabled
service apache2 reload
echo "127.0.0.1    $DOMAIN_NAME" >> /etc/hosts

if [ ! -f /usr/bin/composer ]; then
 curl -sS https://getcomposer.org/installer | php
 mv composer.phar /usr/bin/composer
fi

# Add swap to the VM (200MB)
/bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=200
/sbin/mkswap /var/swap.1
/sbin/swapon /var/swap.1

# Do not run this - not enough memory
# cd /vagrant
# composer install

set +e
rm -f /opt/software/filebot/cache/*
rm -f /opt/software/filebot/data/*
set -e

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

php /vagrant/app/console --no-interaction doctrine:migrations:migrate
php /vagrant/app/console cache:warmup

ln -s /usr/bin/nodejs /usr/bin/node

/etc/init.d/apache2 start
/etc/init.d/transmission-daemon start

# This creates the cache / data directories
set +e
filebot -script fn:sysinfo
set -e

chown -R $SERVICES_USER:$SERVICES_USER /opt/software/filebot/data
filebot -script fn:sysinfo
echo "Enter OpenSubtitles credentials... "
filebot -script fn:osdb.login

# Build the client out of the VM running
# npm i & ./start-client.sh
