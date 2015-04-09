app.controller 'searchController', ['$scope', 'apiFactory', 'utilsService', '$window', '$location', 'Torrent', ($scope, apiFactory, utilsService, $window, $location, Torrent) ->

  promise = null
  reloadPage = false

  $scope.searchSites = [
      { id: "KT", name: 'Kickass Torrents'},
      { id: "DT", name: 'Divx Total', selected: true}
  ]
  $scope.buttonText = "Download"

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
      utilsService.resolvePromiseWithCallbacks promise, onSuccess, null, null
    return
  # When loading the page - injected JSON
  $scope.initTorrents = (torrentsInfo) ->
    $scope.buttonText = "Download"
    $scope.searchSites = [
      { id: "KT", name: 'Kickass Torrents'},
      { id: "DT", name: 'Divx Total', selected: true}
    ]
    if torrentsInfo?
      populateScopeWithTorrents(torrentsInfo)
      return

  $scope.startDownload = (torrentDefinition) ->
    torrentDownload = new Torrent()
    # copies properties over from 2 to 1 - torrentDefinition to torrentDownload
    _.extend torrentDownload, torrentDefinition
    torrentDefinition.state = "Starting..."
    $scope.buttonText = "Starting..."
    torrentDownload.$save((data) ->
      # The resource entity is actually data, but we want it to be data.torrent
      # We have to move the __proto from data to data.torrent
      data.torrent.state = _str.capitalize data.torrent.state?.toLowerCase()
      _.extend torrentDefinition, data.torrent
      $scope.buttonText = torrentDefinition.state
      return
    )

    # TODO: either refactor torrent API to use resource properly or use another endpoint
  $scope.cancelDownload = (torrent) ->
    torrent.$delete((data) ->
      torrent.state = "Cleared"
      return
    )
    return

  populateScopeWithTorrents = (torrentsInfo) ->
    _.map torrentsInfo.torrents, (elem) ->
      elem.state = _str.capitalize elem.state.toLowerCase()
      return
    # TODO: create proper torrent entities from search results to then use resource plugin
    $scope.torrents = torrentsInfo.torrents
    $scope.query = torrentsInfo.query
    $scope.limit = torrentsInfo.limit
    $scope.offset = torrentsInfo.offset
    $scope.currentOffset = torrentsInfo.currentOffset
    $scope.total = torrentsInfo.total
    $scope.searchFinished = true
    $scope.loading = false

  onSuccess = (responseData) ->
    populateScopeWithTorrents(responseData.torrentsInfo)
    return

  return
]