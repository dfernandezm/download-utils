#!/bin/sh

set -e

SERVICES_USER=pi
SEVERAL_JAVA_VERSIONS=0
EXTERNAL_HD_UUID=0
EXTERNAL_HDD_MOUNT_POINT=/media/external-hdd
TRANSMISSION_LOG_LOCATION=/data/transmission/logs
# Indicates if the Media Download Automator runs in a different machine than transmission / XBMC-Kodi
REMOTE=0

# In /etc/apt/sources.list
# Change wheezy to jessie, so that it looks like this:
#deb http://mirrordirector.raspbian.org/raspbian/ jessie main contrib no

apt-get update

apt-get upgrade

apt-get autoremove

apt-get install ntfs-3g

sed -i 's/XKBLAYOUT="gb"/XKBLAYOUT="es"' /etc/default/keyboard


# Create folders for software
# useradd david
mkdir -p /opt/software
chown $SERVICES_USER:$SERVICES_USER -R /opt/software
wget --no-verbose --no-cookies --no-check-certificate --header "Cookie: oraclelicense=accept-securebackup-cookie" \
"http://download.oracle.com/otn-pub/java/jdk/8u33-b05/jdk-8u33-linux-arm-vfp-hflt.tar.gz" -O /tmp/jdk-8u33-linux-arm.tar.gz
tar zxvf /tmp/jdk-8u33-linux-arm.tar.gz -C /opt/software

if [ "$SEVERAL_JAVA_VERSIONS" -eq 1 ]; then
  JAVA_EXEC=java8
else
  JAVA_EXEC=java
fi

sudo update-alternatives --install /usr/bin/$JAVA_EXEC $JAVA_EXEC /opt/software/jdk1.8.0_33/bin/java 1
sudo update-alternatives --config $JAVA_EXEC

# Install PHP 5.5+
sudo apt-get install php5 php-pear libyaml-dev make
sudo pecl install yaml
# add extension=yaml.so to php.ini

# Install Apache
sudo apt-get install apache2 apache2-mpm-prefork apache2.2-bin apache2.2-common libapache2-mod-php5
# Enable mod rewrite
sudo ln -s /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load

# Install MySQL
sudo apt-get install mysql-server php5-mysql --fix-missing

# Install and configure transmission
sudo apt-get install transmission-daemon

# Install mediainfo / libmediainfo
# In mint LMDE is in path
# ./usr/lib/x86_64-linux-gnu/libmediainfo.so.0.0.0
# ./usr/lib/x86_64-linux-gnu/libmediainfo.so
# ./usr/lib/x86_64-linux-gnu/libmediainfo.so.0
apt-get install mediainfo libmediainfo-dev

# Change users for services Apache and Transmission
SED_APACHE_USER="s/APACHE_RUN_USER=www-data/APACHE_RUN_USER=$SERVICES_USER/g"
SED_APACHE_GROUP="s/APACHE_RUN_USER=www-data/APACHE_RUN_GROUP=$SERVICES_USER/g"
SED_TRANSMISSION_USER="s/USER=debian-transmission/USER=$SERVICES_USER/g"

sed -i "$SED_APACHE_USER" /etc/apache2/envvars
sed -i "$SED_APACHE_GROUP" /etc/apache2/envvars
sed -i "$SED_TRANSMISSION_USER" /etc/init.d/transmission-daemon

sudo mkdir -p /var/www/dutils
sudo chown -R $SERVICES_USER:$SERVICES_USER /var/www/dutils

chown $SERVICES_USER:$SERVICES_USER $TRANSMISSION_LOG_LOCATION/transmission.log
chown $SERVICES_USER:$SERVICES_USER /var/lib/transmission-daemon/info/settings.json
chown $SERVICES_USER:$SERVICES_USER /var/lib/transmission-daemon/resume
chown $SERVICES_USER:$SERVICES_USER /var/lib/transmission-daemon/torrents
chown $SERVICES_USER:$SERVICES_USER /var/lib/transmission-daemon/blocklists

# TODO: Edit settings.json

# Install Filebot as $SERVICES_USER. Tidy up permission for 'cache' and 'temp' folders
FILEBOT_HOME=/opt/software/filebot
OPENSUBTITLES_USER=davidfm
OPENSUBTITLES_PASSWORD=ZVCvrasp
mkdir -p $FILEBOT_HOME
chmod +rwx -R $FILEBOT_HOME
chown -R $SERVICES_USER:$SERVICES_USER $FILEBOT_HOME
wget -qO /tmp/filebot.zip http://sourceforge.net/projects/filebot/files/latest/download
unzip -qo /tmp/filebot.zip -d $FILEBOT_HOME && rm -f /tmp/filebot.zip
SED_EXPR="s/java\s-D/$JAVA_EXEC -D/g"
sed -i "$SED_EXPR" $FILEBOT_HOME/filebot.sh
ln -s $FILEBOT_HOME/filebot.sh /usr/bin/filebot
echo "net/filebot/osdb.user=$OPENSUBTITLES_USER\:$OPENSUBTITLES_PASSWORD" >> $FILEBOT_HOME/prefs.properties
mkdir -p $FILEBOT_HOME/cache && chown $SERVICES_USER:$SERVICES_USER $FILEBOT_HOME/cache
mkdir -p $FILEBOT_HOME/temp && chown $SERVICES_USER:$SERVICES_USER $FILEBOT_HOME/temp

# Create mediacenter, NFS share, mount HDD
./create-mediacenter-raspberrypi.sh

# Install XBMC
./install-xbmc.sh

# Setup paths for mediacenter

# Install nodejs and modules

# Setup application / paths / parameters

# Start services: apache, transmission, mysql
