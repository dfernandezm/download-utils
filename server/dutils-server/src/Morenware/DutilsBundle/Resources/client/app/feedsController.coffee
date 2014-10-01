app.controller 'feedsController', ['$scope', 'Feed',  '$route', '$routeParams', ($scope, Feed) ->

  $scope.feeds = Feed.getAll()

  $scope.saveFeed = (feed) ->
    feed.$save((f) ->
      console.log("Saved " + f)
      return
    )
    return

  $scope.updateFeed = (feed) ->
    feed.$update((f) ->
        console.log("Updated " + f)
        return
    )
    return

]