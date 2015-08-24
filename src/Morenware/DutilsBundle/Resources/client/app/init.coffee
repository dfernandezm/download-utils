window._str = require '../lib/underscore.string.min.js'
window._ = require '../lib/underscore.min.js'
window.moment = require 'moment'

require '../lib/angular.min.js'
require '../lib/angular-route.min.js'
require '../lib/angular-resource.min.js'
require '../lib/ui-bootstrap-tpls-0.12.1.min.js'
require './setup.coffee'
require './searchFactory.coffee'
require './utilsService.coffee'

require './feeds.coffee'
require './feedsController.coffee'

require './searchController.coffee'
require './torrents.coffee'
require './torrentsStatusController.coffee'

require './components/adminForm/adminForm.coffee'
require './components/adminTable/adminTable.coffee'
# feature
require './components/torrentStatus/torrentsTable/torrentsTable.coffee'
# feature
require './components/torrentList/torrentElements/torrentElements.coffee'
require './components/filters/filters.coffee'

require './components/progressBar/progressBar.coffee'
require './torrentFactory.coffee'
require './torrentController.coffee'
require './modules/automatedSearchModule.coffee'
