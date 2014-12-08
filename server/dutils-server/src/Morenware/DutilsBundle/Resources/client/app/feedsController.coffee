app.controller 'feedsController', ['$scope', 'Feed', '$rootScope', ($scope, Feed, $rootScope) ->

  init = ->
    $scope.feeds = Feed.getAll()
    $scope.showForm = false
    $scope.submitText = "Add"
    $scope.formTitle = "Feeds Form"
    $scope.showForm = false
    return

  $scope.action = ->
    collect()
    update()
    return

  save = ->
    $scope.feed.$save((f) ->
      console.log("Feed saved " + f)
      init()
      return
    )
    return

  update = ->
    $scope.feed.$update((f) ->
        console.log("Updated " + f)
        return
    )
    return

  $scope.newFeed = ->
    $scope.showForm = true
    $scope.feed = new Feed()
    return

  $scope.getSelectedFeed = ->
    return $scope.feed

  $scope.editFeed = (feed) ->
    $scope.showForm = true
    $scope.feed = feed
    $scope.submitText = "Update"

    for field in $scope.fields
      field.value = feed.url if field.name is 'Url'
      field.value = feed.description if field.name is 'Description'

    return

  collect = ->
    for field in $scope.fields
      $scope.feed.url = field.value if field.name is 'Url'
      $scope.feed.description = field.value if field.name is 'Description'

  init()

  return
]