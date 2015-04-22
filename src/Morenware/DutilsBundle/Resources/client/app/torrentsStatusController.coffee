app.controller 'torrentsStatusController', ['$scope', '$window', ($scope, $window) ->

  $scope.init = (torrents) ->
    $scope.torrents = torrents
    return

  return
]
