app.controller 'searchController', ['$scope', 'apiFactory', 'utilsService', '$window', '$location', 'Torrent', ($scope, apiFactory, utilsService, $window, $location, Torrent) ->

  promise = null
  reloadPage = false

  $scope.searchSites = [
      { id: "KT", name: 'Kickass Torrents'},
      { id: "DT", name: 'Divx Total', selected: true}
  ]

  $scope.search = ->

    if reloadPage
      # Gives all on the left of the ? or everything if not ? is present
      url = _str.strLeft $location.$$absUrl, '?'
      $window.location.href =  url + "?searchQuery=" + $scope.query
    else
      searchQuery = $scope.query
      searchSites = _.where $scope.searchSites, {selected: true}
      sitesParam = ""
      _.each searchSites, (elem,index,list) ->
        sitesParam = sitesParam + elem.id + ","
        return

      sitesParam = sitesParam.replace(/,$/, "")

      # Loading
      $scope.loading = true
      promise = apiFactory.searchTorrent searchQuery, sitesParam
      utilsService.resolvePromiseWithCallbacks promise, onSearchSuccess, null, null
    return

  onSearchSuccess = (data) ->
    $scope.torrents = data.torrentsInfo.torrents
    $scope.query = data.torrentsInfo.query
    $scope.limit = data.torrentsInfo.limit
    $scope.offset = data.torrentsInfo.offset
    $scope.currentOffset = data.torrentsInfo.currentOffset
    $scope.total = data.torrentsInfo.total
    $scope.searchFinished = true
    $scope.loading = false
    return

  $scope.initTorrents = (torrentsInfo) ->
    if torrentsInfo?
      $scope.torrents = torrentsInfo.torrents
      $scope.query = torrentsInfo.query
      $scope.limit = torrentsInfo.limit
      $scope.offset = torrentsInfo.offset
      $scope.currentOffset = torrentsInfo.currentOffset
      $scope.total = torrentsInfo.total
      $scope.searchFinished = true
      return

  $scope.downloadTorrentFile = (torrent) ->
     promise = apiFactory.downloadTorrentFile torrent
     utilsService.resolvePromiseWithCallbacks promise, onDownloadSuccess, null, null

  $scope.startDownload = (torrent) ->
    $scope.torrentDownload = new Torrent()
    $scope.torrentDownload.magnetLink = torrent.magnetLink
    $scope.torrentDownload.torrentFileLink = torrent.torrentFileLink
    $scope.torrentDownload.state = "STARTING..."

    $scope.torrentDownload.$save((torrentDownload) ->
      console.log("Torrent started " + torrentDownload)
      torrent = torrentDownload
      return
    )

  $scope.onDownloadSuccess = (data) ->
    return

  onDownloadStarted =  (data) ->
    return
  return
]