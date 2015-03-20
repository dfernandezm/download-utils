#!/bin/bash

sudo sysctl fs.inotify.max_user_watches=10000
npm run gulp-dev