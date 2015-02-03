#!/bin/sh

# Run as sudo!

# lsusb -- HD drive -- 1058:1042
RULE_PATH=/etc/udev/rules.d/80-mount-disk.rules
MOUNT_SCRIPT_PATH=/home/pi/download-utils/util/mount-disk.sh
# UMOUNT_SCRIPT_PATH=/home/pi/download-utils/util/umount-disk.sh
chmod +x $MOUNT_SCRIPT_PATH
# chmod +x $UMOUNT_SCRIPT_PATH
echo 'ACTION=="add", SUBSYSTEM=="usb", ATTR{idVendor}=="1058", ATTR{idProduct}=="1042", RUN+="$MOUNT_SCRIPT_PATH"' >> $RULE_PATH

# on remove we remount
echo 'ACTION=="remove", SUBSYSTEM=="usb", ATTR{idVendor}=="1058", ATTR{idProduct}=="1042", RUN+="$MOUNT_SCRIPT_PATH"' >> $RULE_PATH
service udev restart