#!/bin/sh

NOTIFY_URL=%NOTIFY_URL%

curl -i -X PUT $NOTIFY_URL
