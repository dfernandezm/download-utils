#!/bin/sh
BASE_SCRIPT=/home/pi/download-utils
chmod -R +x ./

# Check feeds for new torrents every day at 02:00 am
echo "Installing cron job for feed checker ..."
./cron-installer.sh $BASE_SCRIPT/automation/feed-checker.py "00 02 * * *"
echo "Done"

# keep disk mounted
echo "Installing cron job to avoid automatic unmount of HD ..."
./cron-installer.sh $BASE_SCRIPT/cronjobs/keep-alive.sh "15 * * * *"
echo "Done"

/etc/init.d/cron restart
