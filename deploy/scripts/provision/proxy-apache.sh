#!/bin/bash

$SCRIPTS_DIR=$PWD

cd /etc/apache2/mods-enabled
ln -s ../mods-available/proxy.conf proxy.conf
ln -s ../mods-available/proxy.load proxy.load
ln -s ../mods-available/proxy_http.load proxy_http.load

cp $SCRIPTS_DIR/proxy-apache.conf /etc/apache2/sites-enabled/proxy-apache.conf

sudo /etc/init.d/apache2 restart
