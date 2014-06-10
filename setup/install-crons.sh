#!/bin/sh
BASE_CRONS=$BASE_DUTILS/cronjobs
BASE_AUTOMATION=$BASE_DUTILS/autsomation

chmod -R +x $BASE_DUTILS

# Check feeds for new torrents every day at 02:00 am
echo "Installing cron job for feed checker ..."
$BASE_CRONS/cron-installer.sh $BASE_AUTOMATION/feed-checker.py "00 02 * * *"
echo "Done"

# keep disk mounted
echo "Installing cron job to avoid automatic unmount of HD ..."
$BASE_CRONS/cron-installer.sh $BASE_CRONS/keep-alive.sh "15 * * * *"
echo "Done"

/etc/init.d/cron restart
