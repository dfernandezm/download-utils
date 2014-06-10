#!/bin/sh
MOUNT_POINT=$DISK_MOUNT_POINT
touch $MOUNT_POINT/keepAlive.txt
rm $MOUNT_POINT/keepAlive.txt