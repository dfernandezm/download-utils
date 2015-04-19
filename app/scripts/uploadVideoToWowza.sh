#!/bin/sh

ORIGINAL_VIDEO_PATH="/mediacenter/TV Shows/The 100/Season 1/The 100 1x01 Pilot.mp4"
SYMLINK_NAME="the-100-pilot-3.mp4"
WOWZA_CONTENT_DIR="/usr/local/WowzaStreamingEngine/content"
CMD="ln -s \"$ORIGINAL_VIDEO_PATH\" \"$WOWZA_CONTENT_DIR/$SYMLINK_NAME\""
echo "CMD is $CMD"
eval $CMD
