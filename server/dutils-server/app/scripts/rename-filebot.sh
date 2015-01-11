#!/bin/sh

echo "Executing script with rename Filebot..."
LOG_LOCATION="%LOG_LOCATION%"
ACTION=move

filebot -script fn:amc --output "%VIDEO_LIBRARY_BASE_PATH%" --log-file $LOG_LOCATION --action $ACTION -non-strict "%BASE_DOWNLOADS_PATH%" \
        --def clean=y --def subtitles=en,es --conflict auto --def skipExtract=y --def unsorted=y \
        --def "seriesFormat=TV Shows/{n.upperInitial().replaceTrailingBrackets()}/{'Season '+s}/{n.upperInitial().replaceTrailingBrackets()} {s}x{e.pad(2)} {t}" "movieFormat=Movies/{n} ({y})/{n}" --def xbmc=%XBMC_HOSTNAME%


