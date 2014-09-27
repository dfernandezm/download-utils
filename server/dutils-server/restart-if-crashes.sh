#!/bin/sh

$1

until [ $? -lt 0 ]; do

  echo "Process '$1' crashed with exit code $?.  Restarting..." >&2

  sleep 1

  $1

done