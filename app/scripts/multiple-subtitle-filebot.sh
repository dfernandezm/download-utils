#!/bin/bash

# Store inside filebot directory in prefs.properties the username / password for OpenSubtitles - 200 subs a day by default
FB_EXEC=filebot
LOG_LOCATION=%LOG_LOCATION%.log
SUBS_LANG=%SUBS_LANGUAGES%
IFS=","
# Bash array - needs a substitution with a string like ==> ("path/to/files/1" "/path/to/files/2" ...)
INPUT_ARRAY=%INPUT_PATHS%
COUNT=${#INPUT_ARRAY[@]}
echo "Input Array: ${INPUT_ARRAY[*]}"

for ((i = 0; i < ${#INPUT_ARRAY[@]}; i++)) 
do
  INPUT_PATH="${INPUT_ARRAY[$i]}"
  for LANG in $SUBS_LANG
  do
    # We do -get-subtitles as if we would have done -get-missing-subtitles, it would only fetch subtitles in case there are no previous ones 
    FETCH_SUBS_CMD="$FB_EXEC -r -get-subtitles \"$INPUT_PATH\" --lang $LANG --output srt --encoding utf8 -non-strict --log-file \"$LOG_LOCATION\""
    echo "Command executed:" >> $LOG_LOCATION
    echo "$FETCH_SUBS_CMD" >> $LOG_LOCATION
    eval $FETCH_SUBS_CMD
  done
   
  REPLACE1_CMD="$FB_EXEC -r -script fn:replace --log-file $LOG_LOCATION --action move --def \"e=[.](spa|spanish)[.]srt\" \"r=.es.srt\" \"$INPUT_PATH\""
  echo "Command executed: " >> $LOG_LOCATION
  echo "$REPLACE1_CMD " >> $LOG_LOCATION
  eval $REPLACE1_CMD

  REPLACE2_CMD="$FB_EXEC -r -script fn:replace --log-file $LOG_LOCATION --action move --def \"e=[.](eng|english)[.]srt\" \"r=.en.srt\" \"$INPUT_PATH\""
  echo "Command executed: " >> $LOG_LOCATION
  echo "$REPLACE2_CMD " >> $LOG_LOCATION
  eval $REPLACE2_CMD

done




