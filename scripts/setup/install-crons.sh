#!/bin/sh

BASE_AUTOMATION=$DUTILS_DIRECTORY/automation

# Cron daemon should run on startup, in xbmc this needs to be enabled in their settings under .xbmc

# Check feeds for new torrents every day at 02:00 am
echo "Installing cron job for feed checker ..."
$DUTILS_CRONS/cron-installer.sh $BASE_AUTOMATION/feed-checker.py "00 02 * * *"
echo "Done"

# keep disk mounted
echo "Installing cron job to avoid automatic unmount of HD ..."
$DUTILS_CRONS/cron-installer.sh $DUTILS_CRONS/keep-alive.sh "15 * * * *"
echo "Done"

/etc/init.d/cron restart
