mod =  (Feed) ->

  getAll = (actionWhenDone) ->
    return Feed.getAll((data) ->
      actionWhenDone()
    )

  save = (feed) ->
    # the parameter 'feed' is the saved value coming from the server
    feed.$save((savedFeed) ->
      console.log("Feed saved " + feed)
      return savedFeed
    )
    return

  update = (feed) ->
    feed.$update((updatedFeed) ->
        console.log("Updated " + feed)
        # $scope.feed = null
        # $scope.showFeedsForm = false
        return updatedFeed
    )
    return
  remove = (feed) ->
    feed.$delete((data) ->
      console.log("Feed deleted!")
      #$scope.feed = null
      #$scope.feeds = getAllFeeds()
    )
    return

  return {
    getAll: getAll
    save: save
    update: update
    remove: remove
  }
  
mod.$inject = ['Feed']
