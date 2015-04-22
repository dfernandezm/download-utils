#!/bin/bash

# Test data
# mkdir -p "/home/david/test subtitles"
# cd "/home/david/test subtitles"
# touch test1.eng.srt test2.eng.srt test3.eng.srt test1.spa.srt test2.spa.srt test3.spa.srt
# cd ..

SUBS_LANG=en-eng,es-spa
IFS=","
INPUT_PATH="/home/david/test subtitles"

TMPDIR="/tmp/$RANDOM"
mkdir -p $TMPDIR

for LANG in $SUBS_LANG
do
	TWO_CODE_LANG=$( echo "$LANG" | awk -F '-' '{print $1}')
	THREE_CODE_LANG=$( echo "$LANG" | awk -F '-' '{print $2}')

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
