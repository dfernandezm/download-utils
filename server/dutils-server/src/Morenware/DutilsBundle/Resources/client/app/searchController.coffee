app.controller 'searchController', ['$scope', 'apiFactory', 'utilsService', '$window', '$location', ($scope, apiFactory, utilsService, $window, $location) ->

  promise = null
  reloadPage = true

  $scope.search = ->

    if reloadPage
      # Gives all on the left of the ? or everything if not ? is present
      url = _str.strLeft $location.$$absUrl, '?'
      $window.location.href =  url + "?searchQuery=" + $scope.query
    else
      searchQuery = $scope.query
      promise = apiFactory.searchTorrent searchQuery
      utilsService.resolvePromiseWithCallbacks promise, onSearchSuccess, null, null
    return

  onSearchSuccess = (data) ->
    $scope.torrents = data
    $scope.searchFinished = true
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

  $scope.onDownloadSuccess = (data) ->
    return
  return
]