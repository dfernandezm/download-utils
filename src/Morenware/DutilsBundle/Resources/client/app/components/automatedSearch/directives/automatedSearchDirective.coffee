
# Injects the factory/service
# Requires the adminForm, adminTable
# The template of this directive has adminForm and adminTable directives
# All the functions needed in the template are in the link function of this directive
# Do any filters
# require '../torrentElement/torrentElement.coffee'
 # mod = angular
 #       .module 'dutils-automated-search-directive', []
      # require '../../adminForm/adminForm.coffee'
      # require '../../adminTable/adminTable.coffee'
#])
adminForm = require '../../adminForm/adminForm'
adminTable = require '../../adminTable/adminTable'
template = require './automatedSearch.html'
mod = angular
      .module('automatedSearch-directive',[adminForm, adminTable])
      .directive 'automatedSearch', ->
        restrict: 'E'
        replace: true
        transclude: true
        scope: {}
        template: template
        link: (scope, iElement, iAttrs, controller) ->
            return

module.exports = mod.name
