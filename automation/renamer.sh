#!/bin/bash

source ../setup/create-envvars.sh
RENAMER_SCRIPT_LOCATION=$DUTILS_DIRECTORY/automation
SCRIPT_CLASSPATH=$DUTILS_DIRECTORY/lib/log4j-1.2.17.jar

groovy -cp $SCRIPT_CLASSPATH $RENAMER_SCRIPT_LOCATION/Renamer.groovy -bp $TV_SHOWS_BASE -f ../util/tvshows.txt

