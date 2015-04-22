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

TMPDIR=/tmp/$RANDOM

mkdir $TMPDIR

for ((i = 0; i < ${#INPUT_ARRAY[@]}; i++))
do
  INPUT_PATH="${INPUT_ARRAY[$i]}"
  for LANG in $SUBS_LANG
  do
    TWO_CODE_LANG=$( echo "$LANG" | awk -F '-' '{print $1}')
    THREE_CODE_LANG=$( echo "$LANG" | awk -F '-' '{print $2}')
    # We do -get-subtitles as if we would have done -get-missing-subtitles, it would only fetch subtitles in case there are no previous ones
    FETCH_SUBS_CMD="$FB_EXEC -r -get-subtitles \"$INPUT_PATH\" --lang $TWO_CODE_LANG --output srt --encoding utf8 -non-strict --log-file \"$LOG_LOCATION\""
    echo "Command executed:" >> $LOG_LOCATION
    echo "$FETCH_SUBS_CMD" >> $LOG_LOCATION
    eval $FETCH_SUBS_CMD

    # 3-letter language code to 2-letter language code copy
    COPY_IN_CMD="cp \"$INPUT_PATH\"/*.$THREE_CODE_LANG.srt $TMPDIR"
    COPY_BACK_CMD="cp $TMPDIR/*.$TWO_CODE_LANG.srt \"$INPUT_PATH\""

    echo "Executing $COPY_IN_CMD"
    eval $COPY_IN_CMD

    RENAME_CMD="rename 's/\.$THREE_CODE_LANG\.srt/\.$TWO_CODE_LANG.srt/' $TMPDIR/*.$THREE_CODE_LANG.srt"
    echo "Executing $RENAME_CMD"
    eval $RENAME_CMD

    echo "Executing $COPY_BACK_CMD"
    eval $COPY_BACK_CMD

  done

done




