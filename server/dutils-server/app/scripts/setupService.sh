#!/bin/sh

#groupadd -g 605 dutils
#useradd -u 605 -g dutils dutils

runAsDutils() {

    if [ `whoami` = 'dutils' ]
    then
      eval "$cmd"
    else
        /bin/su - dutils -c "$cmd"
    fi
}

