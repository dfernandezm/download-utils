#!/bin/sh

FB_EXEC=filebot
LOG_LOCATION=%LOG_LOCATION%.log
SUB_LOG_LOCATION=%LOG_LOCATION%_sub.log
REPLACE_SUB_LOG_LOCATION1=%LOG_LOCATION%_replace_sub1.log
REPLACE_SUB_LOG_LOCATION2=%LOG_LOCATION%_replace_sub2.log
ACTION=move
PREFERRED_SUBS_LANG=%PREFERRED_SUBS_LANG%
ADDITIONAL_SUBS_LANG=%ADDITIONAL_SUBS_LANG%
INPUT="\"%BASE_DOWNLOADS_PATH%\""
OUTPUT="\"%VIDEO_LIBRARY_BASE_PATH%\""

if [ -n "$PREFERRED_SUBS_LANG" ]; then
  SUBS_PREFERENCE="subtitles=$PREFERRED_SUBS_LANG"
fi

FILEBOT_AMC_CMD="$FB_EXEC -script fn:amc --output $OUTPUT --log-file $LOG_LOCATION --action $ACTION -non-strict $INPUT --def clean=y --conflict auto --def skipExtract=y"
FILEBOT_AMC_CMD="$FILEBOT_AMC_CMD --def unsorted=y --def \"seriesFormat=TV Shows/{n.upperInitial()}/{'Season '+s}/{n.upperInitial()} {s}x{e.pad(2)} {t}\" \"movieFormat=Movies/{n} ({y})/{n}\""
FILEBOT_AMC_CMD="$FILEBOT_AMC_CMD --def xbmc=%XBMC_HOSTNAME% $SUBS_PREFERENCE"

echo "Command executed: \n" >> $LOG_LOCATION
echo "$FILEBOT_AMC_CMD \n" >> $LOG_LOCATION

# If we do not use eval here, the quotes around seriesFormat and movieFormat are deleted and the command fails
eval $FILEBOT_AMC_CMD

if [ -n "$ADDITIONAL_SUBS_LANG" ]; then

 # We do -get-subtitles as if we would have done -get-missing-subtitles, it would only fetch subtitles in case there are no previous ones 
 FETCH_SUBS_CMD="$FB_EXEC -r -get-subtitles $OUTPUT --lang $ADDITIONAL_SUBS_LANG --output srt --encoding utf8 -non-strict --log-file $SUB_LOG_LOCATION"
 echo "Command executed: \n" >> $SUB_LOG_LOCATION
 echo "$FETCH_SUBS_CMD \n" >> $SUB_LOG_LOCATION
 eval $FETCH_SUBS_CMD
	 
 # The expression "[.]srt$" gives an error when no files are matched, but everything seems to work anyway 
 REPLACE1_CMD="$FB_EXEC -r -script fn:replace --log-file $REPLACE_SUB_LOG_LOCATION1 --action move --filter \"[.]srt$\" --def \"e=[.](spa|spanish)\" \"r=.es\" $OUTPUT"
 echo "Command executed: \n" >> $REPLACE_SUB_LOG_LOCATION1
 echo "$REPLACE1_CMD \n" >> $REPLACE_SUB_LOG_LOCATION1
 eval $REPLACE1_CMD 

 REPLACE2_CMD="$FB_EXEC -r -script fn:replace --log-file $REPLACE_SUB_LOG_LOCATION2 --action move --filter \"[.]srt$\" --def \"e=[.](eng|english)\" \"r=.en\" $OUTPUT"
 echo "Command executed: \n" >> $REPLACE_SUB_LOG_LOCATION2
 echo "$REPLACE2_CMD \n" >> $REPLACE_SUB_LOG_LOCATION2
 eval $REPLACE2_CMD 
 
fi

