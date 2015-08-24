template = require './renderTorrentState.html'
app.directive 'renderTorrentState', [ ->
  template: template,
  restrict: 'E',
  replace: true,
  transclude: true,
  scope: {
   torrent: '='
  },
  link: (scope, iElement, iAttrs, controller) ->


    scope.cssConfig = require './config/cssConfig.json'

    scope.process = (torrent) ->
      torrentState = torrent?.state
      stateText = torrentState.replace(/_/g," ")
      if torrentState is 'DOWNLOADING'
        cssClass = "label-primary"
      else if torrentState is 'AWAITING_DOWNLOAD'
        cssClass = "label-default"
      else if torrentState is 'PAUSED'
        cssClass = "label-info"
      else if torrentState is 'RENAMING' or torrentState is 'RENAMING_COMPLETED' or torrentState is 'FETCHING_SUBTITLES' or torrentState is 'DOWNLOAD_COMPLETED'
        cssClass = "label-warning"
      else if torrentState is 'FAILED_DOWNLOAD_ATTEMPT' or torrentState is 'COMPLETED_WITH_ERROR'
        cssClass = "label-danger"
      else
        cssClass = "label-success"
      return {
        cssClass: cssClass
        stateText: stateText
      }

    return
]
