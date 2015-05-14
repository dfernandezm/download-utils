#!/bin/bash

cp dutils-vhost-template.conf dutils-vhost.conf
SERVER_NAME=$1
DOCUMENT_ROOT="$2"
APACHE_VHOSTS_PATH=$3
RELOAD_COMMAND=$4

## Escape path for sed using bash find and replace
DOCUMENT_ROOT="${DOCUMENT_ROOT//\//\\/}"

echo "Document root is $DOCUMENT_ROOT"

SED_DR="s/%DOCUMENT_ROOT%/${DOCUMENT_ROOT}/g"
echo "SED is $SED_DR"
SED_SN="s/%SERVER_NAME%/$SERVER_NAME/g"
sed -i "$SED_DR" dutils-vhost.conf
sed -i "$SED_SN" dutils-vhost.conf
sudo mv dutils-vhost.conf $APACHE_VHOSTS_PATH
# specific to raspberry pi
sudo /etc/init.d/apache2 reload
