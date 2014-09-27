app = window.app = angular.module 'dutilsApp', ['ngRoute']

app.config ['$routeProvider', ($routeProvider) ->
  $routeProvider.when('/instances', {
    controller: 'instanceController',
    templateUrl: '../client/html/instances.html'
  })
  .when('/feeds', {
    controller: 'feedsController',
    templateUrl: '../client/html/feeds.html'
  })
  # .otherwise {redirectTo: '/'}
]