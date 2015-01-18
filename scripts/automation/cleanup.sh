#!/bin/bash

source /opt/download-utils/setup/create-envvars.sh
GROOVY_SCRIPT_LOCATION=$DUTILS_DIRECTORY/automation
SCRIPT_CLASSPATH=$DUTILS_DIRECTORY/lib/log4j-1.2.17.jar

groovy -cp $SCRIPT_CLASSPATH $GROOVY_SCRIPT_LOCATION/Renamer.groovy -bp $TV_SHOWS_BASE -cleanup