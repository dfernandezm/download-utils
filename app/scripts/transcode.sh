#!/bin/sh

TV_SHOW="%TV_SHOW_NAME%"
SEASON="%SEASON_NUMBER"
EPISODE="%EPISODE_NAME%.%INPUT_FILE_EXTENSION%"
OUTPUT_FILE="%EPISODE_NAME%.mp4"

INPUT_BASE_PATH="%TV_SHOWS_BASE_PATH%"
TEMP_OUTPUT_PATH="%TRANSCODE_TEMP_OUTPUT_PATH%"
OUTPUT_BASE_PATH="%OUTPUT_BASE_PATH%"

INPUT_PATH="$INPUT_BASE_PATH/$TV_SHOW/Season $SEASON/$EPISODE"
OUTPUT_PATH="$OUTPUT_BASE_PATH/$TV_SHOW/Season $SEASON/"

mkdir -p "$TEMP_OUTPUT_PATH"
mkdir -p "$OUTPUT_PATH"

rm ffmpeg_ouput*

ffmpeg -y -i "$INPUT_PATH" -c:v libx264 -preset medium -crf 20 -maxrate 1100k -bufsize 2200k -threads 0 -c:a libfaac -b:a 128k  "$TEMP_OUTPUT_PATH/$OUTPUT_FILE"

mv "$TEMP_OUTPUT_PATH/$OUTPUT_FILE" "$OUTPUT_PATH"

# Reduced bitrate
#  ffmpeg -y -i "/mediacenter/TV Shows/The Big Bang Theory/Season 8/The Big Bang Theory 8x19 The Skywalker Incursion.mkv" -c:v libx264 -preset medium -crf 20 -maxrate 600k -bufsize 1200k -threads 0 -c:a libfaac -b:a 128k
# /home/david/# Documents/tbbt-819.mp4
