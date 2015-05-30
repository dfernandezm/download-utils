app.controller 'torrentController', ['$scope', 'torrentFactory', ($scope, torrentFactory) ->

  # Way to add extra object/info to a success/error callback by defining this creator closure and
  # http://stackoverflow.com/questions/939032/jquery-pass-more-parameters-into-callback/939206#939206
  # http://stackoverflow.com/questions/24963151/passing-parameters-to-promises-callback-in-angularjs
  startTorrentDownloadSuccessCallbackCreator = (torrentDefinition) ->
    return (responseData, status, headers, config) ->
      responseData.torrent.date = moment(responseData.torrent.date).format('YYYY-MM-DD')
      _.extend torrentDefinition, responseData.torrent
      torrentDefinition.buttonText = 'Cancel'
      return

  cancelTorrentDownloadSuccessCallbackCreator = (torrentDefinition) ->
    return (responseData, status, headers, config) ->
      torrentDefinition.state = "NEW"
      torrentDefinition.buttonText = "Start"
      return

  pauseTorrentSuccessCallbackCreator = (torrentDefinition) ->
    return (responseData, status, headers, config) ->
      _.extend torrentDefinition, responseData.torrent
      return

  resumeTorrentSuccessCallbackCreator = (torrentDefinition) ->
    return (responseData, status, headers, config) ->
      _.extend torrentDefinition, responseData.torrent
      return

  $scope.startDownload = (torrentDefinition) ->
    torrentDownload = {}
    torrentDefinition.date = moment(torrentDefinition.date).format('YYYY-MM-DD[T]HH:mm:ssZZ')
    # copies properties over from 2 to 1 - torrentDefinition to torrentDownload
    _.extend torrentDownload, torrentDefinition
    torrentDefinition.buttonText = "Starting..."
    successCallback = startTorrentDownloadSuccessCallbackCreator(torrentDefinition)
    torrentFactory.torrentAction "START",torrentDownload,successCallback,onError
    return

  # TODO: either refactor torrent API to use resource properly or use another endpoint
  $scope.cancelDownload = (torrentDefinition) ->
    torrentGuidOrHash = torrentDefinition.hash
    torrentDefinition.buttonText = "Cancelling..."
    successCallback = cancelTorrentDownloadSuccessCallbackCreator(torrentDefinition)
    torrentFactory.torrentAction "CANCEL",torrentDefinition,successCallback,onError
    return

  $scope.pauseDownload = (torrentDefinition) ->
    torrentDefinition.buttonText = "Pausing..."
    successCallback = pauseTorrentSuccessCallbackCreator(torrentDefinition)
    torrentFactory.torrentAction "PAUSE",torrentDefinition,successCallback,onError
    return

  $scope.resumeDownload = (torrentDefinition) ->
    torrentDefinition.buttonText = "Resuming..."
    successCallback = resumeTorrentSuccessCallbackCreator(torrentDefinition)
    torrentFactory.torrentAction "RESUME",torrentDefinition,successCallback,onError
    return

  $scope.fetchSubtitles = (torrentDefinition) ->
    torrentDefinition.buttonText = "Fetching..."
    successCallback = pauseTorrentSuccessCallbackCreator(torrentDefinition)
    torrentFactory.torrentAction "SUBTITLES",torrentDefinition,successCallback,onError
    return

  $scope.rename = (torrentDefinition) ->
    torrentDefinition.buttonText = "Renaming..."
    successCallback = pauseTorrentSuccessCallbackCreator(torrentDefinition)
    torrentFactory.torrentAction "RENAME",torrentDefinition,successCallback,onError
    return

  onError = (responseData) ->
    $scope.errors = "Error in request"
    console.log($scope.errors)
    return

  return
]
