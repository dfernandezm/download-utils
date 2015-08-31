template = require './torrentActions.html'

mod = angular
      .module('torrentActions-directive', [])
      .directive 'torrentActions', [ ->
        template: template,
        restrict: 'E',
        replace: true,
        transclude: true,
        scope: {
          torrent: '='
        },
        link: (scope) ->
          return
      ]

module.exports = mod.name
