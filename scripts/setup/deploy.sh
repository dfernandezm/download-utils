#!/bin/bash

INSTALL_AFTER_DEPLOY=$1
HOST=$2
DESTINATION_FOLDER=$3
USER=$4


if [ "$HOST" == "localhost" ]
then
    echo "Creating destination directory $DESTINATION_FOLDER"
    mkdir -p $DESTINATION_FOLDER
    echo "Copying files to destination ..."
    cp -R ../../download-utils/*  $DESTINATION_FOLDER
    echo "Copy done"
else
    echo "Connecting to $HOST as $USER to send app to $DESTINATION_FOLDER ..."
    ssh $USER@HOST 'mkdir -p $DESTINATION_FOLDER'
    scp ../../download-utils/* $USER@$HOST:$DESTINATION_FOLDER
    echo "Transmission correct"
fi

if [ $? -eq 0 -a -n "$1" -a "$1" == "--install" ]
then
    echo "Executing setup..."
    chmod +x setup.sh
    source setup.sh
else
    echo "Error deploying"
fi

