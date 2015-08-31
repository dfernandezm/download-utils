torrentElement = require '../torrentElement/torrentElement'
filters = require '../../filters/filters'
template = require './torrentElements.html'

mod = angular
      .module('torrentElements-directive', [filters,torrentElement])
      .directive 'torrentsElements', [  ->
        template: template,
        restrict: 'E',
        replace: true,
        transclude: true,
        scope: {
          torrents: '='
          filterState: '@'
        },
        link: (scope) ->
          return
      ]

module.exports = mod.name
