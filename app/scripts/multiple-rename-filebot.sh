#!/bin/bash

FB_EXEC=filebot
LOG_LOCATION=%LOG_LOCATION%.log
ACTION=move
# Bash array - needs a substitution with a string like ==> ("path/to/files/1" "/path/to/files/2" ...), values separated by spaces
INPUT_ARRAY=%INPUT_PATHS%
COUNT=${#INPUT_ARRAY[@]}
# echo "Input Array: ${INPUT_ARRAY[*]} - COUNT"
OUTPUT="\"%VIDEO_LIBRARY_BASE_PATH%\""

let i=0
for INPUT_PATH in ${INPUT_ARRAY[*]}
do

  FILEBOT_AMC_CMD="$FB_EXEC -script fn:amc --output \"$OUTPUT\" --log-file $LOG_LOCATION --action $ACTION -non-strict \"$INPUT_PATH\" --def clean=y --conflict auto --def skipExtract=y"
  FILEBOT_AMC_CMD="$FILEBOT_AMC_CMD --def unsorted=y --def \"seriesFormat=TV Shows/{n.upperInitial()}/{'Season '+s}/{n.upperInitial()} {s}x{e.pad(2)} {t}\" \"movieFormat=Movies/{n} ({y})/{n}\""
  
  let c=$COUNT-1

  if [ "$i" -eq "$c" ]; then
     FILEBOT_AMC_CMD="$FILEBOT_AMC_CMD --def xbmc=%XBMC_HOSTNAME%"
  fi

  let i=$i+1

  echo "Command executed:" >> $LOG_LOCATION
  echo "$FILEBOT_AMC_CMD " >> $LOG_LOCATION

  eval $FILEBOT_AMC_CMD

done




