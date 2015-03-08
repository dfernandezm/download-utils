#!/bin/bash

sudo sysctl fs.inotify.max_user_watches=100000
npm run gulp-dev