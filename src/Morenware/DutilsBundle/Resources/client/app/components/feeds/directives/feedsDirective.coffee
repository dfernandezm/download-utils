adminForm = require '../../adminForm/adminForm'
adminTable = require '../../adminTable/adminTable'
feedsApi = require '../feedsApi'

template = require './feeds.html'
mod = angular
      .module('feeds-directive',[adminForm, adminTable, feedsApi])
      .directive 'feeds', [ 'Feed', (Feed)  ->
        restrict: 'E'
        replace: true
        transclude: true
        template: template
        scope: {}
        link: (scope) ->
          scope.newFeed =  ->
            scope.submitText = "Add"
            scope.formTitle = "Add new feed"
            scope.actionToPerform = "add"
            scope.showFeedsForm = true
            console.log('HTTP '+Feed)
            scope.feed = new Feed()
            return
          return
      ]

module.exports = mod.name
