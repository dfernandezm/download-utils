#!/bin/sh
# usage: source create-envvars.sh as sudo

# needed env vars -- used by other scripts
export DUTILS_DIRECTORY=/opt/download-utils
export DUTILS_RENAMER=${DUTILS_DIRECTORY}/automation/renamer.sh
export DUTILS_CRONS=$DUTILS_DIRECTORY/cronjobs

export DISK_MOUNT_POINT=/media/Elements_
export TV_SHOWS_BASE=${DISK_MOUNT_POINT}/series
export DUTILS_RENAMER_LOG=$DUTILS_DIRECTORY/logs/renamer.log
export DUTILS_FEEDCHECKER_LOG=$DUTILS_DIRECTORY/logs/feed-checker.log