#!/bin/bash

sudo sysctl fs.inotify.max_user_watches=524288
npm run gulp-dev