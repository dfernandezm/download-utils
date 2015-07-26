app.factory 'torrentFactory', ['$http', ($http) ->

  startUrl = "api/torrents/start" # provide object with magnet link / torrent link
  cancelUrl = "api/torrents/cancel" # provide GUID
  pauseUrl = "api/torrents/pause" # provide GUID
  resumeUrl = "api/torrents/resume" # provide GUID
  renameUrl = "api/torrents/rename" # provide GUID
  subtitlesUrl = "api/torrents/subtitles" # provide GUID
  pollStatusUrl = "api/torrents/status"

  torrentFactory = {}

  addCallbacks = (promise, successCallback, errorCallback) ->
    promise.success(successCallback).error(errorCallback)
    return

  torrentFactory.torrentAction = (action, torrent, successCallback, errorCallback) ->
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
      return

    addCallbacks(res,successCallback,errorCallback)

    return

  torrentFactory.pollTorrentsStatus = (successCallback, errorCallback) ->
    res = $http.put(pollStatusUrl)
    addCallbacks(res, successCallback, errorCallback)
    return res

  return torrentFactory
]
