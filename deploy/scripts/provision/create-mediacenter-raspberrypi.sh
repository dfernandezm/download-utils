#!/bin/sh
set -e

PI_USER=pi
MEDIA_ROOT_DIRECTORY_NAME=media

# Folders in external HD according to XBMC-Kodi structure
HDD_UUID=1ADC8962DC893951
HDD_MOUNT_POINT=/media/Elements
HDD_MEDIA_ROOT=$HDD_MOUNT_POINT/$MEDIA_ROOT_DIRECTORY_NAME
MOVIES_HDD_PATH=$HDD_MEDIA_ROOT/Movies
TV_SHOWS_HDD_PATH="$HDD_MEDIA_ROOT/TV Shows"

# RASPBERRY PI symlinks
MEDIA_CENTER_ROOT_LINK=/mediacenter
TV_SHOWS_LINK=/home/$PI_USER/tv-shows
MOVIES_LINK=/home/$PI_USER/movies

REMOTE=0

# Check HDD UUID, Add entry to fstab for that, mount all
echo "Adding HDD mount to /etc/fstab, UUID: $HDD_UUID, mount point: $HDD_MOUNT_POINT"
echo "UUID=$HDD_UUID $HDD_MOUNT_POINT ntfs-3g defaults,uid=pi,gid=pi 0 0" >> /etc/fstab
mount -a

echo "Creating necessary directories for mediacenter in HDD..."
if [ ! -f $HDD_MEDIA_ROOT ]; then
   mkdir -p $HDD_MEDIA_ROOT	
fi

if [ ! -f $MOVIES_HDD_PATH ]; then
   mkdir -p $MOVIES_HDD_PATH	
fi

if [ ! -f $TV_SHOWS_HDD_PATH ]; then
   mkdir -p $TV_SHOWS_HDD_PATH	
fi

chown -R david $HDD_MEDIA_ROOT

# Create symbolic links
echo "Creating symbolic link $HDD_MEDIA_ROOT -> $MEDIA_CENTER_ROOT_LINK"
ln -s $HDD_MEDIA_ROOT $MEDIA_CENTER_ROOT_LINK

echo "Creating symbolic link $TV_SHOWS_HDD_PATH -> $TV_SHOWS_LINK"
ln -s $TV_SHOWS_HDD_PATH $TV_SHOWS_LINK

echo "Creating symbolic link $MOVIES_HDD_PATH -> $MOVIES_LINK"
ln -s $MOVIES_HDD_PATH $MOVIES_LINK
 
# Create NFS share for the mediacenter if needed
if [ "$REMOTE" -eq 1 ]; then
  echo "Preparing NFS share for $MEDIA_CENTER_ROOT_LINK.."
  
  echo "Install NFS server..."
  apt-get -y install nfs-kernel-server portmap nfs-common

  echo "Adding exports..." 
  echo "$MEDIA_CENTER_ROOT_LINK 192.168.1.0/24(rw,insecure,no_subtree_check,async)"  >>  /etc/exports
  
  /etc/init.d/nfs-kernel-server restart

  # To mount the exported system, run on the client:
  # sudo mount {SERVER_IP}:/mediacenter /mediacenter

fi
