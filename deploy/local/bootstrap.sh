#!/bin/bash

# Need to be root for this.
[ `whoami` = root ] || echo "This script needs to run as root -- please enter root password: "
[ `whoami` = root ] || exec su -c $0 root

set -e

SERVICES_USER=pi
SEVERAL_JAVA_VERSIONS=0
EXTERNAL_HD_UUID=0
EXTERNAL_HDD_MOUNT_POINT=/media/external-hdd
TRANSMISSION_LOG_LOCATION=/opt/software/logs/transmission

apt-get -y update
set +e
echo "set nocompatible \n set backspace=2" >> /home/vagrant/.vimrc
echo "set nocompatible \n set backspace=2" >> /root/.vimrc
echo "set nocompatible \n set backspace=2" >> /home/$SERVICES_USER/.vimrc
set -e

# Install PHP 5.5+
apt-get -y install php5 php-pear libyaml-dev make php5-dev php5-curl
pecl install yaml

add extension=yaml.so to php.ini

# Install Apache
apt-get -y install apache2 apache2-mpm-prefork apache2.2-bin apache2.2-common libapache2-mod-php5
# Enable mod rewrite
ln -s /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load

# Install MySQL
apt-get -y install mysql-server php5-mysql
apt-get -y install ntfs-3g

# mkdir -p /opt/software
# Make this repeatable
useradd pi
#TODO: does not work in Debian based Linux
echo 'password1' | passwd pi --stdin

chown $SERVICES_USER:$SERVICES_USER -R /opt/software
wget --no-verbose --no-cookies --no-check-certificate --header "Cookie: oraclelicense=accept-securebackup-cookie" \
"http://download.oracle.com/otn-pub/java/jdk/8u51-b16/jdk-8u51-linux-x64.tar.gz" -O /tmp/jdk-8u51-linux-x64.tar.gz
tar zxvf /tmp/jdk-8u51-linux-x64.tar.gz -C /opt/software

if [ "$SEVERAL_JAVA_VERSIONS" -eq 1 ]; then
     JAVA_EXEC=java8
else
     JAVA_EXEC=java
fi

update-alternatives --install /usr/bin/$JAVA_EXEC $JAVA_EXEC /opt/software/jdk1.8.0_51/bin/java 1
update-alternatives --config $JAVA_EXEC

# Transmission and Apache config

# Install and configure transmission
apt-get install -y transmission-daemon

# Install mediainfo / libmediainfo
# In mint LMDE is in path
# ./usr/lib/x86_64-linux-gnu/libmediainfo.so.0.0.0
# ./usr/lib/x86_64-linux-gnu/libmediainfo.so
# ./usr/lib/x86_64-linux-gnu/libmediainfo.so.0
apt-get install -y mediainfo libmediainfo-dev

# Change users for services Apache and Transmission
SED_APACHE_USER="s/APACHE_RUN_USER=www-data/APACHE_RUN_USER=$SERVICES_USER/g"
SED_APACHE_GROUP="s/APACHE_RUN_GROUP=www-data/APACHE_RUN_GROUP=$SERVICES_USER/g"
SED_TRANSMISSION_USER="s/USER=debian-transmission/USER=$SERVICES_USER/g"

sed -i "$SED_APACHE_USER" /etc/apache2/envvars
sed -i "$SED_APACHE_GROUP" /etc/apache2/envvars
sed -i "$SED_TRANSMISSION_USER" /etc/init.d/transmission-daemon

mkdir -p /var/www/dutils
chown -R $SERVICES_USER:$SERVICES_USER /var/www/dutils

mkdir -p $TRANSMISSION_LOG_LOCATION
touch $TRANSMISSION_LOG_LOCATION/transmission.log
chown $SERVICES_USER:$SERVICES_USER $TRANSMISSION_LOG_LOCATION/transmission.log
chown -R $SERVICES_USER:$SERVICES_USER /var/lib/transmission-daemon
chown root:root /var/lib/transmission-daemon/info/settings.json
# TODO: Edit settings.json
#
FILEBOT_HOME=/opt/software/filebot
OPENSUBTITLES_USER=davidfm
OPENSUBTITLES_PASSWORD=ZVCvrasp
mkdir -p $FILEBOT_HOME
chmod +rwx -R $FILEBOT_HOME
chown -R $SERVICES_USER:$SERVICES_USER $FILEBOT_HOME
# Need to update this to the latest version -- use the portable JAR!
# https://app.filebot.net/download.php?type=portable&version=4.6
wget -qO $FILEBOT_HOME/filebot.zip http://freefr.dl.sourceforge.net/project/filebot/filebot/FileBot_4.6/FileBot_4.6-portable.zip
unzip -qo $FILEBOT_HOME/filebot.zip -d $FILEBOT_HOME && rm -f $FILEBOT_HOME/filebot.zip


cp /vagrant/deploy/scripts/provision/filebot-rpi-template.sh /vagrant/deploy/scripts/provision/filebot.sh

JAVA_EXEC_SED="s/%JAVA_EXEC%/$JAVA_EXEC/g"
FILEBOT_HOME_ESC="${FILEBOT_HOME//\//\\/}"
FILEBOT_HOME_SED="s/%FILEBOT_HOME%/$FILEBOT_HOME_ESC/g"
sed -i "$JAVA_EXEC_SED" /vagrant/deploy/scripts/provision/filebot.sh
sed -i "$FILEBOT_HOME_SED" /vagrant/deploy/scripts/provision/filebot.sh
mv /vagrant/deploy/scripts/provision/filebot.sh $FILEBOT_HOME
chmod +x $FILEBOT_HOME/filebot.sh
chown -R $SERVICES_USER:$SERVICES_USER $FILEBOT_HOME
ln -s $FILEBOT_HOME/filebot.sh /usr/bin/filebot
mkdir -p $FILEBOT_HOME/data
echo "net/filebot/osdb.user=$OPENSUBTITLES_USER\:$OPENSUBTITLES_PASSWORD" >> $FILEBOT_HOME/data/prefs.properties
echo "net/filebot/osdb.user=$OPENSUBTITLES_USER\:$OPENSUBTITLES_PASSWORD" >> $FILEBOT_HOME/prefs.properties
mkdir -p $FILEBOT_HOME/cache && chown $SERVICES_USER:$SERVICES_USER $FILEBOT_HOME/cache
mkdir -p $FILEBOT_HOME/temp && chown $SERVICES_USER:$SERVICES_USER $FILEBOT_HOME/temp
chown -R $SERVICES_USER:$SERVICES_USER /opt/software

apt-get -y install git
apt-get -y install nodejs npm
apt-get install php5-mysql

# Create mediacenter, NFS share, mount HDD
chmod +x /vagrant/deploy/local/create-mediacenter-local.sh
/vagrant/deploy/local/create-mediacenter-local.sh
