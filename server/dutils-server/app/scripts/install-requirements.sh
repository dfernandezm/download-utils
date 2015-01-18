#!/bin/sh

# ================= Filebot - requires Java 1.8 =====================================================

FILEBOT_HOME=/opt/software/filebot
# mkdir -p $FILEBOT_HOME
# chmod +rwx -R $FILEBOT_HOME
# wget -qO $FILEBOT_HOME/filebot.zip http://downloads.sourceforge.net/project/filebot/filebot/FileBot_4.5/FileBot_4.5-portable.zip
unzip -qo $FILEBOT_HOME/filebot.zip -d $FILEBOT_HOME/filebot && rm -f $FILEBOT_HOME/filebot.zip

# Beanstalk queue -- not needed so far
# sudo apt-get install beanstalkd 

# ================== NFS Server in the mediacenter machine (Rpi) ==================

ORIGINAL_EXPORTED_PATH=/media/Elements_/series
SYMLINKED_MEDIACENTER_PATH=/mediacenter
HOST_MOUNT_POINT=/mediacenter

echo "Checking necessary packages are installed..."
apt-get -y install nfs-kernel-server portmap nfs-common

if [ ! -f $SYMLINKED_MEDIACENTER_PATH ]; then
        echo "Creating symlink to mediacenter..."
        mkdir -p $SYMLINKED_MEDIACENTER_PATH
        ln -s $ORIGINAL_EXPORTED_PATH $SYMLINKED_MEDIACENTER_PATH
        echo "Adding exports..."
        echo "$SYMLINKED_MEDIACENTER_PATH 192.168.1.0/24(rw,insecure,no_subtree_check,async)"  >>  /etc/exports
fi

/etc/init.d/nfs-kernel-server restart

# To mount the exported system
# sudo mount 192.168.1.68:/mediacenter /mediacenter



