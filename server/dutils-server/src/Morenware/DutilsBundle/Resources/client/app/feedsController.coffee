# TODO: add error callbacks
app.controller 'feedsController', ['$scope', 'Feed', ($scope, Feed) ->

  init = ->
    $scope.loading = true
    $scope.feeds = Feed.getAll((data) ->
      $scope.loading = false
      console.log("Feeds loaded")
    )
    $scope.showFeedsForm = false
    $scope.submitText = "Add"
    $scope.formTitle = "Add new feed"
    $scope.actionToPerform = "add"

    $scope.feedsFields = [
      {
        label: "Url",
        name: "url",
        type: "text",
        value: null
      },
      {
        label: "Description",
        name: "description",
        type: "text",
        value: null
      },
      {
        label: "Active",
        name: "active",
        type: "boolean",
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

  deleteFeed = ->
    $scope.feed.$delete((feed) ->
      console.log("Feed deleted!")
    )

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