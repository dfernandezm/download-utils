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
 
 # 3-letter language code to 2-letter language code copy
 
 COMMAND_ENG="cp \"$INPUT_PATH\"/*.eng.srt /tmp"
 COMMAND_SPA="cp \"$INPUT_PATH\"/*.spa.srt /tmp"

 COPY_BACK_CMD_ES="cp /tmp/*.en.srt \"$INPUT_PATH\""
 COPY_BACK_CMD_EN="cp /tmp/*.es.srt \"$INPUT_PATH\""

 echo "Executing $COMMAND_ENG"
 eval $COMMAND_ENG

 echo "Executing $COMMAND_SPA"
 eval $COMMAND_SPA

 rename 's/\.eng\.srt/\.en.srt/' /tmp/*.eng.srt
 rename 's/\.spa\.srt/\.es.srt/' /tmp/*.spa.srt

 echo "Executing $COPY_BACK_CMD_EN" 
 eval $COPY_BACK_CMD_EN

 echo "Executing $COPY_BACK_CMD_ES"
 eval $COPY_BACK_CMD_ES 
    
done




