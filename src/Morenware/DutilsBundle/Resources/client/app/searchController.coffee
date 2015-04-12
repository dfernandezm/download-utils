app.controller 'searchController', ['$scope', 'searchFactory', 'utilsService', '$window', '$location', 'Torrent', ($scope, searchFactory, utilsService, $window, $location, Torrent) ->

  promise = null
  reloadPage = false

  $scope.searchSites = [
      { id: "TPB", name: 'The Pirate Bay'},
      { id: "KT", name: 'Kickass Torrents'},
      { id: "DT", name: 'Divx Total', selected: true}
  ]
  $scope.buttonText = "Download"

  # Way to add extra object/info to a success/error callback by defining this closure creator and
  # http://stackoverflow.com/questions/939032/jquery-pass-more-parameters-into-callback/939206#939206
  # http://stackoverflow.com/questions/24963151/passing-parameters-to-promises-callback-in-angularjs
  startTorrentDownloadSuccessCallbackCreator = (torrentDefinition) ->
    return (responseData, status, hearders, config) ->
      responseData.torrent.state = _str.capitalize responseData.torrent.state?.toLowerCase()
      responseData.torrent.date = moment(responseData.torrent.date).format('YYYY-MM-DD')
      _.extend torrentDefinition, responseData.torrent
      torrentDefinition.state = 'Downloading'
      torrentDefinition.buttonText = 'Cancel'
      return

  cancelTorrentDownloadSuccessCallbackCreator = (torrentDefinition) ->
    return (responseData, status, hearders, config) ->
      torrentDefinition.state = "New"
      torrentDefinition.buttonText = "Download"
      return

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
      promise = searchFactory.searchTorrent searchQuery, sitesParam, onSuccess, onError
      utilsService.resolvePromiseWithCallbacks promise, onSuccess, onError, null, null
    return

  # When loading the page - injected JSON
  $scope.initTorrents = (torrentsInfo) ->
    $scope.buttonText = "Download"
    $scope.searchSites = [
      { id: "TPB", name: 'The Pirate Bay'},
      { id: "KT", name: 'Kickass Torrents'},
      { id: "DT", name: 'Divx Total', selected: true}
    ]
    if torrentsInfo?
      populateScopeWithTorrents(torrentsInfo)
      return

  $scope.startDownload = (torrentDefinition) ->

    torrentDownload = {}
    torrentDefinition.date = moment(torrentDefinition.date).format('YYYY-MM-DD[T]HH:mm:ssZZ')
    # copies properties over from 2 to 1 - torrentDefinition to torrentDownload
    _.extend torrentDownload, torrentDefinition
    torrentDefinition.buttonText = "Starting..."

    successCallback = startTorrentDownloadSuccessCallbackCreator(torrentDefinition)
    searchFactory.startTorrentDownload torrentDownload, successCallback, onError

    return

  # TODO: either refactor torrent API to use resource properly or use another endpoint
  $scope.cancelDownload = (torrentDefinition) ->

    torrentGuidOrHash = torrentDefinition.hash
    torrentDefinition.buttonText = "Cancelling..."

    successCallback = cancelTorrentDownloadSuccessCallbackCreator(torrentDefinition)
    searchFactory.cancelTorrentDownload torrentGuidOrHash, successCallback, onError

    return

  populateScopeWithTorrents = (torrentsInfo) ->
    _.map torrentsInfo.torrents, (torrent) ->
      torrent.buttonText = if torrent.state == 'NEW' then "Download" else "Cancel"
      torrent.state = _str.capitalize torrent.state.toLowerCase()
      torrent.date = moment(torrent.date, 'YYYY-MM-DD').format('YYYY-MM-DD')

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

  onError = (responseData) ->
    $scope.errors = "Error in request"
    console.log($scope.errors)
    return

  return
]