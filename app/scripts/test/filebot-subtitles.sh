#!/bin/sh

FILEBOT_EXEC=filebot
PATH=%MEDIA_PATH%
LANGUAGES=%SUBTITLES_LANGUAGE%

$FILEBOT_EXEC -r -get-subtitles $PATH --lang $LANGUAGES --output srt --encoding utf8 -non-strict
