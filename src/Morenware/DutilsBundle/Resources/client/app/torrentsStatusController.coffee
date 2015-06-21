app.controller 'torrentsStatusController', ['$scope', '$interval', '$timeout', 'torrentFactory', ($scope, $interval, $timeout, torrentFactory) ->

  pollPromise = null
  continuePolling = true
  $scope.isPolling = false
  $scope.dateInterval = null

  $scope.init = (torrents) ->
    $scope.torrents = torrents
    $scope.$on('$destroy', ->
      # Make sure that the interval is destroyed too
      $scope.stopPolling()
      return
    )
    $scope.startPollingStatus()
    return

  onSuccess = (data) ->
    console.log "Successfully polled"

    #if (data.torrents.length == 0)
    #  $scope.stopPolling()
    $scope.torrents = data.torrents unless data.torrents?.length == 0
    if continuePolling
      pollPromise = $timeout(pollForStatus,5000)
    return

  pollForStatus = ->
    return torrentFactory.pollTorrentsStatus onSuccess, onError

  $scope.startPollingStatus = ->
    if pollPromise? && angular.isDefined(pollPromise)
      return
    pollForStatus()
    $scope.isPolling = true
    return

  $scope.startPolling = ->
    pollForStatus()
    $scope.isPolling = continuePolling = true
    return

  $scope.stopPolling = ->
    if pollPromise? && angular.isDefined(pollPromise)
      $timeout.cancel(pollPromise)
      continuePolling = $scope.isPolling = false
    return

  onError = (responseData) ->
    $scope.errors = "Error in request"
    console.log($scope.errors)
    return
]
