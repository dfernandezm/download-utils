#!/bin/bash

MOUNT_POINT=/media/Elements_
sudo umount $MOUNT_POINT
sudo mount -t ntfs-3g -o uid=pi,gid=pi /dev/sdb1 $MOUNT_POINT