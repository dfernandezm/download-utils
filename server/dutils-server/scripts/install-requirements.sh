#!/bin/sh

# detect if npm, uglify etc are installed
# npm install -g uglify-js

# Filebot - requires Java 1.8
FILEBOT_HOME=/opt/software/filebot
# mkdir -p $FILEBOT_HOME
# chmod +rwx -R $FILEBOT_HOME
# wget -qO $FILEBOT_HOME/filebot.zip http://downloads.sourceforge.net/project/filebot/filebot/FileBot_4.5/FileBot_4.5-portable.zip
unzip -qo $FILEBOT_HOME/filebot.zip -d $FILEBOT_HOME/filebot && rm -f $FILEBOT_HOME/filebot.zip

# Beanstalk queue

sudo apt-get install beanstalkd 



