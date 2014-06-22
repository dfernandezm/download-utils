#!/bin/sh

# basic setup
mkdir -p /opt/download-utils
mkdir -p /opt/download-utils/logs
chmod -R +x /opt/download-utils

source create-envvars.sh

if [ $? -eq 0 ]
then
    source install-crons.sh
    if [ $? -eq 0 ]
    then
        echo "Basic installation finished"
    else
        echo "There was an error installing CRON jobs"
    fi
else
    echo "Error sourcing creation of Environment variables"
fi