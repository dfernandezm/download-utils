#!/bin/sh

SERVICES_USER=david
SEVERAL_JAVA_VERSIONS=0
EXTERNAL_HD_UUID=0
EXTERNAL_HDD_MOUNT_POINT=/media/external-hdd
TRANSMISSION_LOG_LOCATION=/data/transmission/logs

apt-get update

# Install Apache
apt-get install apache2

# Install PHP 5.4+
apt-get install php

# Install MySQL
apt-get install mysql

# Install transmission daemon
apt-get install transmission-daemon

# Change users for services Apache and Transmission 

sed -i 's/APACHE_RUN_USER=www-data/APACHE_RUN_USER=david/g' /etc/apache2/envvars
sed -i 's/APACHE_RUN_USER=www-data/APACHE_RUN_GROUP=david/g' /etc/apache2/envvars
sed -i 's/USER=debian-transmission/USER=david/g' /etc/init.d/transmission-daemon

chown david $TRANSMISSION_LOG_LOCATION/transmission.log
chown david /var/lib/transmission-daemon/info/settings.json 
chown david /var/lib/transmission-daemon/resume
chown david /var/lib/transmission-daemon/torrents
chown david /var/lib/transmission-daemon/blocklists

# Install virtualhost in Apache


# Install java 8 - if there are more versions of java running, use alternate
wget --no-verbose --no-cookies --no-check-certificate --header "Cookie: oraclelicense=accept-securebackup-cookie" \
"http://download.oracle.com/otn-pub/java/jdk/7u51-b13/jdk-7u51-linux-x64.rpm" -O /tmp/jdk-7-linux-x64.rpm

rpm -Uvh /tmp/jdk-7-linux-x64.rpm

if [ "$USE_SEVERAL_JAVA_VERSIONS" -eq 1 ]; then
  $JAVA_EXEC=java8	
else 
  $JAVA_EXEC=java
fi

alternatives --install /usr/bin/$JAVA_EXEC $JAVA_EXEC /usr/java/jdk1.7.0_51/jre/bin/java 20000
alternatives --set $JAVA_EXEC /usr/java/jdk1.7.0_51/jre/bin/java

# Install Filebot

# Tidy up permission for 'cache' and 'temp' folders


# Setup fstab with external HDD

# Mount disk

# Setup NFS

# Install XBMC

# Setup paths for mediacenter


# Install nodejs and modules

# Setup application / paths ...

# Insert default data in DB

# Build frontend

# Start services: apache, transmission, mysql




