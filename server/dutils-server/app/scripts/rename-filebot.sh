#!/bin/sh

# For this to work when executed from Transmission:
#
# 1. Add debian-transmission (or the user who executes Transmission Daemon Service) in the sudoers file, in order to 
# be able to impersonate as the owner of the Filebot 'cache' and 'temp' folders.
#
# To add debian-transmission as sudoer, add at the bottom of /etc/sudoers
#
# debian-transmission ALL = NOPASSWD: /usr/bin/php, /bin/su
# 
# This will allow debian-transmission to execute sudo su XXXX without prompting for password


echo "Executing script with rename Filebot..."
LOG_LOCATION="%LOG_LOCATION%"
ACTION=move

cmd="filebot -script fn:amc --output \"%VIDEO_LIBRARY_BASE_PATH%\" --log-file $LOG_LOCATION --action $ACTION -non-strict \"%BASE_DOWNLOADS_PATH%\" --def clean=y --def subtitles=en,es --conflict auto --def skipExtract=y --def unsorted=y --def \"seriesFormat=TV Shows/{n.upperInitial().replaceTrailingBrackets()}/{'Season '+s}/{n.upperInitial().replaceTrailingBrackets()} {s}x{e.pad(2)} {t}\" \"movieFormat=Movies/{n} ({y})/{n}\" --def xbmc=%XBMC_HOSTNAME%"

# We need to impersonate as 'david' to execute Filebot or whichever user is the owner of Filebot folders (cache, temp) in order to grant writing access to them
# This could be solved allowing 777 for those folders. The group permission would be the best choice, but somehow it is not working even 'david' and 'debian-transmission'
# are in the same usergroup
sudo su david -c "$cmd"

