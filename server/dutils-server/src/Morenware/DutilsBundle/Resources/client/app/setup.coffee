app = window.app = angular.module 'dutilsApp', ['ngRoute', 'ngResource']

app.config ['$routeProvider','$httpProvider', ($routeProvider, $httpProvider) ->

  # $httpProvider.defaults.headers.get_auth['Authorization'] = 'Basic YWRtaW46YWRtaW5wYXNz'
  # $http.defaults.headers.common.Authorization = 'Basic YWRtaW46YWRtaW5wYXNz'
  $httpProvider.defaults.headers.common['Authorization'] = 'Basic YWRtaW46YWRtaW5wYXNz'

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