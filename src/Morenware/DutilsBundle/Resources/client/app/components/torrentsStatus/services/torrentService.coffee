module.exports = mod = ($http, $timeout) ->

  baseUrl = "api/torrents"
  startUrl = baseUrl + "/start" # provide object with magnet link / torrent link
  cancelUrl = baseUrl + "/cancel" # provide GUID
  pauseUrl = baseUrl + "/pause" # provide GUID
  resumeUrl = baseUrl + "/resume" # provide GUID
  renameUrl = baseUrl + "/rename" # provide GUID
  subtitlesUrl = baseUrl + "/subtitles" # provide GUID
  pollStatusUrl = baseUrl + "/status"

  pollPromise = null
  torrentService = {}

  addCallbacks = (promise, successCallback, errorCallback) ->
    return promise.success(successCallback).error(errorCallback)

  torrentService.getAll = ->
    return $http.put(pollStatusUrl).then( (resp) ->
      return resp.data.torrents
    )

  torrentService.torrentAction = (action, torrent, successCallback, errorCallback) ->
    if action is "START"
      dataObject = {
        torrent: torrent
      }
      res = $http.post(startUrl, dataObject)
    else if action is "CANCEL"
      url = cancelUrl + "/" + torrent.hash
      res = $http.delete(url)
    else if action is "PAUSE"
      url = pauseUrl + "/" + torrent.hash
      res = $http.put(url)
    else if action is "RESUME"
      url = resumeUrl + "/" + torrent.hash
      res = $http.put(url)
    else if action is "RENAME"
      url = renameUrl
      res = $http.put(url)
    else if action is "SUBTITLES"
      url = subtitlesUrl
      res = $http.put(url)
    else
      console.log "Action not recognised " + action

    addCallbacks(res, successCallback, errorCallback)
    return

  torrentService.pollTorrentsStatus = (successCallback, errorCallback) ->
    res = $http.put(pollStatusUrl)
    addCallbacks(res, successCallback, errorCallback)
    return res

  torrentService.stopPolling = ->
    if pollPromise? && angular.isDefined(pollPromise)
      $timeout.cancel(pollPromise)
    return

  torrentService.pollForStatus =  ->
    return $http.put(pollStatusUrl).then (resp) ->
      pollPromise = $timeout(torrentService.pollForStatus(updateAction), 5000)
      return resp.data.torrents

  torrentService.startDownload = (torrentDefinition) ->
    torrentDownload = {}
    torrentDefinition.date = moment(torrentDefinition.date).format('YYYY-MM-DD[T]HH:mm:ssZZ')
    # copies properties over from 2 to 1 - torrentDefinition to torrentDownload
    _.extend torrentDownload, torrentDefinition
    torrentDefinition.buttonText = "Starting..."
    successCallback = startTorrentDownloadSuccessCallbackCreator(torrentDefinition)
    torrentFactory.torrentAction "START",torrentDownload,successCallback,onError
    return

  # TODO: either refactor torrent API to use resource properly or use another endpoint
  torrentService.cancelDownload = (torrentDefinition) ->
    torrentGuidOrHash = torrentDefinition.hash
    torrentDefinition.buttonText = "Cancelling..."
    successCallback = cancelTorrentDownloadSuccessCallbackCreator(torrentDefinition)
    torrentFactory.torrentAction "CANCEL",torrentDefinition,successCallback,onError
    return

  torrentService.pauseDownload = (torrentDefinition) ->
    torrentDefinition.buttonText = "Pausing..."
    successCallback = pauseTorrentSuccessCallbackCreator(torrentDefinition)
    torrentFactory.torrentAction "PAUSE",torrentDefinition,successCallback,onError
    return

  torrentService.resumeDownload = (torrentDefinition) ->
    torrentDefinition.buttonText = "Resuming..."
    successCallback = resumeTorrentSuccessCallbackCreator(torrentDefinition)
    torrentFactory.torrentAction "RESUME",torrentDefinition,successCallback,onError
    return

  torrentService.fetchSubtitles = (torrentDefinition) ->
    torrentDefinition.buttonText = "Fetching..."
    successCallback = pauseTorrentSuccessCallbackCreator(torrentDefinition)
    torrentFactory.torrentAction "SUBTITLES",torrentDefinition,successCallback,onError
    return

  torrentService.rename = (torrentDefinition) ->
    torrentDefinition.buttonText = "Renaming..."
    successCallback = pauseTorrentSuccessCallbackCreator(torrentDefinition)
    torrentFactory.torrentAction "RENAME",torrentDefinition,successCallback,onError
    return



  return torrentService

mod.$inject = ['$http', '$timeout']
