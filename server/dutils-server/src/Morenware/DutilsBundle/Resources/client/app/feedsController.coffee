app.controller 'feedsController', ['$scope', 'Feed',  '$route', '$routeParams', ($scope, Feed, $route) ->

  init = ->
    $scope.feeds = Feed.getAll()
    $scope.showForm = false
    return

  $scope.saveFeed = ->
    $scope.feed.$save((f) ->
      console.log("Feed saved")
      init()
      return
    )
    return

  $scope.updateFeed = ->
    $scope.feed.$update((f) ->
        console.log("Updated " + f)
        return
    )
    return

  $scope.showFeedForm = ->
    $scope.feed = new Feed()
    $scope.showForm = !$scope.showForm
    return

  $scope.editFeed = (feed) ->
    $scope.feed = feed
    $scope.showForm = true
    return

  init()
  return
]