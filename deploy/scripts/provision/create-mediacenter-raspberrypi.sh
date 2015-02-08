#!/bin/sh

# Create folders and symbolic links pointing to external HDD
HDD_UUID=1ADC8962DC893951
HDD_MOUNT_POINT=/media/Elements
HDD_MEDIA_ROOT=$HDD_MOUNT_POINT/series
MOVIES_HDD_PATH=$HDD_MEDIA_ROOT/Movies
TV_SHOWS_HDD_PATH="$HDD_MEDIA_ROOT/TV Shows"
MEDIA_CENTER_ROOT_LINK=/home/pi/mediacenter
TV_SHOWS_LINK=/home/pi/tv-shows
MOVIES_LINK=/home/pi/movies

# Check HDD UUID, Add entry to fstab for that, mount all
echo "UUID=$HDD_UUID /media/$HDD_MOUNT_POINT ntfs-3g defaults,uid=pi,gid=pi 0 0" >> /etc/fstab
mount -a

# Create symbolic links
ln -s $HDD_MEDIA_ROOT $MEDIA_CENTER_ROOT_LINK
ln -s $TV_SHOWS_HDD_PATH $TV_SHOWS_LINK
ln -s $MOVIES_HDD_PATH $MOVIES_LINK
