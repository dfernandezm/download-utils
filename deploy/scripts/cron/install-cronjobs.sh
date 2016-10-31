#!/usr/bin/env bash

# creates OR updates the command in the crontab of the user
COMMAND=$1
CRON_PATTERN=$2
JOB="$CRON_PATTERN $COMMAND"
cat <(fgrep -i -v "$COMMAND" <(crontab -l)) <(echo "$JOB") | crontab -