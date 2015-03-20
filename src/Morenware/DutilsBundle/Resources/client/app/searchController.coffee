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
      # returns objects on the list with the property indicated
      searchSites = _.where $scope.searchSites, {selected: true}
      sitesParam = ""
      _.each searchSites, (elem,index,list) ->
        sitesParam = sitesParam + elem.id + ","
        return
      # remove last comma
      sitesParam = sitesParam.replace(/,$/, "")

      # Loading
      $scope.loading = true
      promise = apiFactory.searchTorrent searchQuery, sitesParam
      utilsService.resolvePromiseWithCallbacks promise, onSearchSuccess, null, null
    return

  onSearchSuccess = (data) ->
    _.map data.torrentsInfo.torrents, (elem) ->
      elem.state = _str.capitalize elem.state.toLowerCase()
      return
    # TODO: create proper torrent entities from search results to then use resource plugin
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

  $scope.startDownload = (torrentDefinition) ->
    torrentDownload = new Torrent()
    # copies properties over from 2 to 1 - torrentDefinition to torrentDownload
    _.extend torrentDownload, torrentDefinition
    torrentDefinition.state = "Starting..."
    torrentDownload.$save((data) ->
      data.torrent.state = _str.capitalize data.torrent.state?.toLowerCase()
      _.extend torrentDefinition, data.torrent
      return
    )

    # TODO: either refactor torrent API to use resource properly or use another endpoint
    $scope.cancelDownload = (torrent) ->
      torrent.$delete((data) ->
        torrent.state = "Cleared"
      )

  return
]