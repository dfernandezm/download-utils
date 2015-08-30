
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
#require '../../adminForm/adminForm.coffee'
#require '../../adminTable/adminTable.coffee'
mod = angular.module('automatedSearch-directive',[])
template = require './automatedSearch.html'
mod.directive 'automatedSearch', ->
    restrict: 'E'
    replace: true
    transclude: true
    scope: {
      t: '='
    }
    template: template
    link: (scope, iElement, iAttrs, controller) ->
        return

module.exports = mod.name
