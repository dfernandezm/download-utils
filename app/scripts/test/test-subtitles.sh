#!/bin/bash

# Test data
# mkdir -p "/home/david/test subtitles"
# cd "/home/david/test subtitles"
# touch test1.eng.srt test2.eng.srt test3.eng.srt test1.spa.srt test2.spa.srt test3.spa.srt
# cd ..

INPUT_PATH="/home/david/test subtitles"
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

