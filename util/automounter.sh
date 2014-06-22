#!/bin/sh

MOUNT_POINT=$DISK_MOUNT_POINT
mkdir -p $MOUNT_POINT
chmod 755 $MOUNT_POINT
mount -t ntfs-3g -o uid=pi,gid=pi /dev/sdb1 $MOUNT_POINT
# chown pi /etc/fstab
# cp /etc/fstab /etc/fstab.backup
# echo "UUID=1ADC8962DC893951 /media/$MOUNT_POINT ntfs-3g defaults,uid=pi,gid=pi 0 0" >> /etc/fstab
# /dev/sdb1     /media/Elements ntfs-3g         defaults,uid=65534,gid=65534,dmask=000,fmask=111 0 0
