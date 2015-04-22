#!/bin/bash

VIDEO_PATH="/mediacenter/TV Shows/The Big Bang Theory/Season 8/The Big Bang Theory 8x21 The Communication Deterioration.mp4"
CONVERTED_NAME="/home/david/Documents/tbbt-821.mp4"
SERVER_IP=castiel
CMD="scp \"$CONVERTED_NAME\" david@$SERVER_IP:~/video-test"
echo "CMD is $CMD"
eval $CMD
