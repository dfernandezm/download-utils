#!/bin/sh

PATH=%MEDIA_PATH%
LANGUAGE=%SUBTITLES_LANGUAGE%

filebot -r -get-subtitles $PATH --lang $LANGUAGE --output srt --encoding utf8 -non-strict
