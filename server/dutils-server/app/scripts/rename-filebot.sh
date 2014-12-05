#!/bin/sh

echo "Executing script with rename Filebot..."

filebot -script fn:amc --output "%VIDEO_LIBRARY_BASE_PATH%" --log-file rename.log --action test -non-strict "%BASE_DOWNLOADS_PATH%" \
        --def gmail=%GMAIL_USER%:%GMAIL_PASSWORD% --def clean=y --def subtitles=en,es --conflict auto --def skipExtract=y \
        --def "seriesFormat=TV Shows/{n}/{'Season '+s}/{fn}" "movieFormat=Movies/{n} ({y})/{fn}" --def xbmc=%XBMC_HOSTNAME%


