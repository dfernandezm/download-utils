#!/bin/bash

# Linux: sudo sysctl fs.inotify.max_user_watches=524288
ulimit -n 2560
npm run gulp-dev
