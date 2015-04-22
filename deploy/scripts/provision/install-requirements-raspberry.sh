#!/bin/sh

set -e

SERVICES_USER=david
SEVERAL_JAVA_VERSIONS=0
EXTERNAL_HD_UUID=0
EXTERNAL_HDD_MOUNT_POINT=/media/external-hdd
TRANSMISSION_LOG_LOCATION=/data/transmission/logs
# Indicates if the Media Download Automator runs in a different machine than transmission / XBMC-Kodi
REMOTE=0

apt-get update

apt-get upgrade

apt-get install ntfs-3g

sed -i 's/XKBLAYOUT="gb"/XKBLAYOUT="es"' /etc/default/keyboard


# Create folders for software
# useradd david
mkdir -p /opt/software
chown david:david -R /opt/software
wget --no-verbose --no-cookies --no-check-certificate --header "Cookie: oraclelicense=accept-securebackup-cookie" \
"http://download.oracle.com/otn-pub/java/jdk/8u33-b05/jdk-8u33-linux-arm-vfp-hflt.tar.gz" -O /tmp/jdk-8u33-linux-arm.tar.gz
tar zxvf /tmp/jdk-8u33-linux-arm.tar.gz -C /opt/software

if [ "$USE_SEVERAL_JAVA_VERSIONS" -eq 1 ]; then
  $JAVA_EXEC=java8	
else 
  $JAVA_EXEC=java
fi

sudo update-alternatives --install /usr/bin/$JAVA_EXEC $JAVA_EXEC /opt/software/jdk-8u33-linux-arm/bin/java 1
sudo update-alternatives --config $JAVA_EXEC

# Install Apache
apt-get install apache2

# Install PHP 5.4+
apt-get install php

# Install MySQL
apt-get install mysql

# Install and configure transmission
apt-get install transmission-daemon

# Install mediainfo / libmediainfo
# In mint LMDE is in path 
# ./usr/lib/x86_64-linux-gnu/libmediainfo.so.0.0.0
# ./usr/lib/x86_64-linux-gnu/libmediainfo.so
# ./usr/lib/x86_64-linux-gnu/libmediainfo.so.0
apt-get install mediainfo libmediainfo-dev

# Change users for services Apache and Transmission 

sed -i 's/APACHE_RUN_USER=www-data/APACHE_RUN_USER=david/g' /etc/apache2/envvars
sed -i 's/APACHE_RUN_USER=www-data/APACHE_RUN_GROUP=david/g' /etc/apache2/envvars
sed -i 's/USER=debian-transmission/USER=david/g' /etc/init.d/transmission-daemon

chown david:david $TRANSMISSION_LOG_LOCATION/transmission.log
chown david:david /var/lib/transmission-daemon/info/settings.json 
chown david:david /var/lib/transmission-daemon/resume
chown david:david /var/lib/transmission-daemon/torrents
chown david:david /var/lib/transmission-daemon/blocklists

# Edit settings.json

# Install virtualhost in Apache

# Install Filebot as $SERVICES_USER. Tidy up permission for 'cache' and 'temp' folders

# Setup fstab with external HDD -- check if there is already an entry for it. Mount disk

# Setup NFS

# Install XBMC

# Setup paths for mediacenter

# Install nodejs and modules

# Setup application / paths / parameters

# Insert default data in DB

# Build frontend

# Start services: apache, transmission, mysql




