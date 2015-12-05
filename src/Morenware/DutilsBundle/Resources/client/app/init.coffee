window._str = require '../lib/underscore.string.min.js'
window._ = require '../lib/underscore.min.js'
window.moment = require 'moment'

require '../lib/angular.min.js'
require '../lib/angular-route.min.js'
require '../lib/angular-resource.min.js'
require '../lib/ui-bootstrap-tpls-0.12.1.min.js'
require './setup.coffee'

# Change to directive
require './searchFactory.coffee'
require './searchController.coffee'

require './components/adminForm/adminForm.coffee'
require './components/adminTable/adminTable.coffee'
