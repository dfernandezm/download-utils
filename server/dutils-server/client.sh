#!/bin/sh

# coffee -o src/Morenware/DutilsBundle/Resources/public/js/app -cw src/Morenware/DutilsBundle/Resources/client/app

# Increase file descriptor limit
sudo sysctl fs.inotify.max_user_watches=524288
sudo sysctl -p


# Gems required (move to Gemfile)
# gem install guard
# gem install guard-livereload
# gem install open4
# gem install guard-rake
# Nodejs misnaming, rename to use
# sudo ln -s /usr/bin/nodejs /usr/bin/node

npm install

rake webpack_watch[local] &

# with this no rake task is launched -> -w src/Morenware/DutilsBundle/Resources

guard