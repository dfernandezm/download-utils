template = require './downloadSingle.html'

mod = angular
      .module('downloadSingle-directive',[])
      .directive 'downloadSingle', [ 'torrentService', (torrentService) ->
        template: template,
        restrict: 'E',
        replace: true,
        transclude: false,
        scope: {},
        link: (scope) ->

          scope.download =  ->
            torrentDefinition = {}

            if _str.startsWith(scope.magnetOrTorrentLink, "magnet:")
              torrentDefinition.magnetLink = scope.magnetOrTorrentLink
            else
              torrentDefinition.torrentFileLink = scope.magnetOrTorrentLink

            torrentDefinition.state = "NEW"
            torrentService.startDownload(torrentDefinition)
            return

          return
      ]

module.exports = mod.name
