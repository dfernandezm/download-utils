app.controller 'feedsController', ['$scope', 'Feed', ($scope, Feed) ->

  init = ->
    $scope.feeds = Feed.getAll()
    $scope.showFeedsForm = false
    $scope.submitText = "Add"
    $scope.formTitle = "Add new feed"
    $scope.actionToPerform = "add"

    $scope.feedsFields = [
      {
        label: "Url",
        name: "url",
        value: null
      },
      {
        label: "Description",
        name: "description",
        value: null
      }
    ]

    return

  $scope.action = ->
    collectValues()
    if $scope.actionToPerform is "add" then save() else update()
    return

  save = ->
    $scope.feed.$save((feed) ->
      console.log("Feed saved " + feed)
      init()
      return
    )
    return

  update = ->
    $scope.formTitle = "Updating..."
    $scope.feed.$update((feed) ->
        console.log("Updated " + feed)
        $scope.feed = null
        $scope.showFeedsForm = false
        return
    )
    return

  $scope.newFeed = ->
    $scope.submitText = "Add"
    $scope.formTitle = "Add new feed"
    $scope.actionToPerform = "add"
    $scope.showFeedsForm = true
    $scope.feed = new Feed()
    return

  # Called from HTML to show the form to update one feed
  $scope.editFeed = (feed) ->
    $scope.formTitle = "Update feed"
    $scope.submitText = "Update"
    $scope.actionToPerform = "update"
    $scope.showFeedsForm = true
    $scope.feed = feed

    for field in $scope.feedsFields
      field.value = feed[field.name]

    return

  collectValues = ->
    for field in $scope.feedsFields
      $scope.feed[field.name] = field.value

  init()

  return
]