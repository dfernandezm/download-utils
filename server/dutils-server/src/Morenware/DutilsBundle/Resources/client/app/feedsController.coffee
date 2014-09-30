app.controller 'feedsController', ['$scope', 'Feed',  '$route', '$routeParams', ($scope, Feed) ->

    getFeeds = () ->
        $scope.feeds = Feed.query()
        return
]