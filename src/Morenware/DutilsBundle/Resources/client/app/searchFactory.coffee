app.factory 'searchFactory', ['$http', ($http) ->

  # $http.defaults.headers.common = {"Access-Control-Request-Headers": "accept, origin, authorization"}
  # $http.defaults.headers.common['Authorization'] = 'Basic YWRtaW46YWRtaW5wYXNz'

  searchUrl = "api/search"
  startDownloadUrl = "api/torrents/start"
  cancelDownloadUrl = "api/torrents/cancel" # provide GUID
  searchFactory = {}

  addCallbacks = (promise, successCallback, errorCallback) ->
    promise.success(successCallback).error(errorCallback)
    return

  # Returns a promise which once resolve will give a torrentsInfo object containing
  # the list of torrents fetch
  searchFactory.searchTorrent = (searchQuery, sitesParam, success, error) ->
    req = {
      method: 'get',
      url: searchUrl,
      params: { searchQuery : searchQuery, sitesParam: sitesParam }
    }
    res = $http(req)
    addCallbacks(res,success,error)
    return

  searchFactory.startTorrentDownload = (torrent, successCallback, errorCallback) ->

    dataObject = {
        torrent: torrent
    }
    res = $http.post(startDownloadUrl, dataObject)
    addCallbacks(res,successCallback,errorCallback)
    return

  searchFactory.cancelTorrentDownload = (torrentGuidOrHash, successCallback, errorCallback) ->
    url = cancelDownloadUrl + "/" + torrentGuidOrHash
    res = $http.delete(url)
    addCallbacks(res,successCallback,errorCallback)
    return

  return searchFactory
]
