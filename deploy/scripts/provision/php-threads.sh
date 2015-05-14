#!/bin/sh

# run as regular user using php

set -e

curl -L -O https://github.com/phpbrew/phpbrew/raw/master/phpbrew
chmod +x phpbrew
sudo mv phpbrew /usr/bin/phpbrew

phpbrew install 5.5.6 +default -- --enable-debug --enable-maintainer-zts

sudo apt-get install libbz2-dev
sudo apt-get install libmcrypt-dev
sudo apt-get install libxslt-dev
